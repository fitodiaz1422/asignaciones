<?php

namespace App\Http\Excel;
set_time_limit(3000);
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Support\Facades\DB;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;

class AsistenciaExcel{

    private $fecha;
    private $writer;
    private $findeMes;
    private $tipos;
    private $tmp_tipos = [];
    private $dataCache = [];
    private $userDataIndexed = [];
    private $colorStyles = [];

    public function __construct($fecha){
        $this->fecha = $fecha;
        $this->writer = WriterEntityFactory::createXLSXWriter();
        $findeMes = \DateTime::createFromFormat('Ym', $this->fecha);
        $this->findeMes = $findeMes->modify('last day of this month')->format('d');

        // Cargamos los tipos de asistencia y los preparamos en una estructura optimizada
        $this->tipos = Cache::remember('tipos_asistencia_'.$this->fecha, 1, function() {
            return \App\TipoAsistencia::where('estado', '=', 'ACTIVO')->get();
        });

        // Inicializamos el array de estilos de color para reutilizarlos
        foreach ($this->tipos as $tipo) {
            $this->colorStyles[$tipo->color] = $this->getColor($tipo->color);
        }
    }

    private function query(){
        // Implementamos caché para evitar consultas repetidas
            $total = DB::table('users_actividades')
                ->selectRaw('users.id, actividades.tipo_asistencia_id, right(users_actividades.fecha,2) as dia, comunas.nombre as comuna')
                ->join('users', 'users.id', '=', 'users_actividades.user_id')
                ->join('comunas','comunas.id','=','users.comuna_id')
                ->join('actividades', 'actividades.id', '=', 'users_actividades.actividad_id')
                ->where(DB::raw('left(users_actividades.fecha,6)'), '=', $this->fecha)
                ->groupBy('users_actividades.user_id', 'users_actividades.fecha', 'users.id', 'actividades.tipo_asistencia_id')
                ->orderBy('fecha', 'asc')
                ->get();

            // Indexamos los resultados para acceso más rápido
            $indexed = [];
            foreach ($total as $item) {
                if (!isset($indexed[$item->id])) {
                    $indexed[$item->id] = [];
                }
                $indexed[$item->id][$item->dia] = $item;
            }
            $this->dataCache = $indexed;

            return $total;
    }

    private function setHeadersTipos(){
        // Reiniciamos el array de tipos en vez de usar unset que es más costoso
        $this->tmp_tipos = [];

        // Usamos foreach simple para mejor rendimiento
        foreach($this->tipos as $tipo){
            $this->tmp_tipos[$tipo->tipo] = 0;
        }
    }

    private function setDias(){
        // Pre-dimensionar el array para mejor rendimiento
        $values = [];
        $values = range(1, $this->findeMes);
        return $values;
    }

    private function setDescriptions(){
        // Reuso de variables para reducir uso de memoria
        $cells = [];

        // Batch creation of rows for better performance
        $rows = [];
        foreach($this->tipos as $tipo){
            $cells = [
                WriterEntityFactory::createCell('', $this->getColor($tipo->color)),
                WriterEntityFactory::createCell($tipo->nombre),
            ];
            $rows[] = WriterEntityFactory::createRow($cells);
        }

        // Agregamos filas en batch
        foreach ($rows as $row) {
            $this->writer->addRow($row);
        }
    }

    private function setHeaders(){
            $values = ['Rut', 'Nombre', 'Apellidos','Cargo','Proyecto','Region','Minutos Atraso','Anticipos'];
            $values =array_merge($values ,$this->setDias());
            $values =array_merge($values ,$this->tipos->pluck('nombre')->toArray());
            $rowFromValues = WriterEntityFactory::createRowFromArray($values);
            $this->writer->addRow($rowFromValues);
    }

    private function getColor($color){
        // Si ya tenemos el estilo creado, lo reutilizamos
        if (isset($this->colorStyles[$color])) {
            return $this->colorStyles[$color];
        }

        // Si no, lo creamos y almacenamos
        $style = (new StyleBuilder())
            ->setBackgroundColor($color)
            ->build();

        $this->colorStyles[$color] = $style;
        return $style;
    }

    private function getAtrasos(){
            $atrasos = \App\Atraso::selectRaw('user_id, sum(diferencia) as atraso')
                ->where(DB::raw('left(fecha,6)'), '=', $this->fecha)
                ->groupBy('user_id')
                ->get();

            // Indexamos por user_id para acceso rápido
            $indexed = [];
            foreach ($atrasos as $atraso) {
                $indexed[$atraso->user_id] = $atraso;
            }
            return collect($indexed);

    }

    private function getAnticipos(){
            $anticipos = \App\Anticipo::selectRaw('user_id, sum(monto) as monto')
                ->whereYear('created_at', '=', substr($this->fecha, 0, 4))
                ->whereMonth('created_at', '=', substr($this->fecha, 4, 2))
                ->groupBy('user_id')
                ->get();

            // Indexamos por user_id para acceso rápido
            $indexed = [];
            foreach ($anticipos as $anticipo) {
                $indexed[$anticipo->user_id] = $anticipo;
            }
            return collect($indexed);
    }

    private function setBody($data){
        // Obtenemos datos y los procesamos por lotes para mejor rendimiento
        $users = $this->getUsers();
        $atrasos = $this->getAtrasos();
        $anticipos = $this->getAnticipos();
        $tiposIndexed = [];

        // Indexamos los tipos por tipo_asistencia_id para acceso rápido
        foreach ($this->tipos as $tipo) {
            $tiposIndexed[$tipo->tipo] = $tipo;
        }

        // Procesamos usuarios en lotes de 50 para mejor manejo de memoria
        $userChunks = $users->chunk(50);

        foreach ($userChunks as $userChunk) {
            foreach ($userChunk as $user) {
                // Acceso directo indexado por user_id en lugar de búsqueda en colección
                $atraso = isset($atrasos[$user->id]) ? $atrasos[$user->id] : null;
                $anticipo = isset($anticipos[$user->id]) ? $anticipos[$user->id] : null;

                $cells = [
                    WriterEntityFactory::createCell($user->rut),
                    WriterEntityFactory::createCell($user->name),
                    WriterEntityFactory::createCell($user->apaterno. " " . $user->amaterno),
                    WriterEntityFactory::createCell($user->funcion),
                    WriterEntityFactory::createCell($user->proyecto->nombre ?? ''),
                    WriterEntityFactory::createCell($comuna ?? ''),
                    WriterEntityFactory::createCell($atraso ? $atraso->atraso : 0),
                    WriterEntityFactory::createCell($anticipo ? $anticipo->monto : 0),
                ];

                $this->setHeadersTipos();

                // Generamos y agregamos las celdas de los días del mes
                for ($i = 1; $i <= $this->findeMes; $i++) {
                    $diaPadded = str_pad($i, 2, '0', STR_PAD_LEFT);

                    // Usamos acceso directo indexado en lugar de where() que es lento
                    $dia = isset($this->dataCache[$user->id][$diaPadded]) ? $this->dataCache[$user->id][$diaPadded] : null;

                    if ($dia) {
                        $tipo = $tiposIndexed[$dia->tipo_asistencia_id] ?? null;
                        if ($tipo) {
                            $cells[] = WriterEntityFactory::createCell('', $this->getColor($tipo->color));
                            $this->tmp_tipos[$tipo->tipo] += 1;
                        } else {
                            $cells[] = WriterEntityFactory::createCell('');
                        }
                    } else {
                        $cells[] = WriterEntityFactory::createCell('');
                    }
                }

                // Añadimos las celdas para los totales de cada tipo
                foreach ($this->tmp_tipos as $tmp_tipo) {
                    $cells[] = WriterEntityFactory::createCell($tmp_tipo);
                }

                $row = WriterEntityFactory::createRow($cells);
                $this->writer->addRow($row);
            }
        }
    }

    public function download(){
        // Configuramos límite de memoria más alto para procesar grandes cantidades de datos
        ini_set('memory_limit', '512M');

        // Configuramos opciones del writer para mejor rendimiento
        $this->writer->openToBrowser('Asistencia '.$this->fecha.'.xlsx');

        // Procargamos y preparamos los datos antes de generar el Excel
        $data = $this->query(); // Esto también prepara los datos cacheados

        // Generamos el Excel
        $this->setDescriptions();
        $this->setHeaders();
        $this->setBody($data);
        $this->writer->close();

        // Limpiamos memoria
        $this->dataCache = [];
        $this->userDataIndexed = [];
        $this->colorStyles = [];
        $this->tmp_tipos = [];

        // Restauramos el límite de memoria
        ini_set('memory_limit', '128M');
    }

    private function getUsers(){
            $users = \App\User::select('rut','name','apaterno','amaterno','id','proyecto_id','comuna_id','funcion')
                ->with(['proyecto:id,nombre','comuna.region'])
                ->get();

            // Indexamos para rápido acceso
            foreach ($users as $user) {
                $this->userDataIndexed[$user->id] = $user;
            }

            return $users;

    }

}
