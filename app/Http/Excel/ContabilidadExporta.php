<?php

namespace App\Http\Excel;

use App\Bonos;
use App\Deposito;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

class ContabilidadExporta
{
    private $fecha;
    private $writer;
    private $tipos;
    private $styleHeader;
    private $colorStyles = [];


    public function __construct($fecha, $tipos = [])
    {
        $this->fecha = $fecha;
        $this->tipos = $tipos;
        $this->writer = WriterEntityFactory::createXLSXWriter();

    }

    private function headers(){
        // Crear estilo para los encabezados
        if (!isset($this->styleHeader)) {
            $this->styleHeader = (new StyleBuilder())
                ->setFontBold()
                ->setFontSize(12)
                ->setBackgroundColor('CCCCCC')
                ->build();
        }

        $data=[
            'Rut Beneficiario',
            'Nombre Beneficiario',
            'Monto',
            'Medio de Pago',
            'Código Banco',
            'Tipo de Cuenta',
            'Número de Cuenta',
            'Email',
            'Referencia Cliente',
            'Glosa Cartola Origen',
            'Glosa Cartola Destino',
            'Detalle de Pago'
        ];

        // Crear celdas con estilo
        $cells = [];
        foreach ($data as $header) {
            $cells[] = WriterEntityFactory::createCell($header, $this->styleHeader);
        }

        $this->writer->addRow(WriterEntityFactory::createRow($cells));
    }

    private function query()
    {
        $data = [];

        // Inicializar las colecciones como vacías por defecto
        $bonos = collect();
        $depositos = collect();

        if(isset($this->tipos['bonos']) && $this->tipos['bonos']){
            $bonos = Bonos::selectRaw('user_id , sum(monto) as monto')
                ->whereRaw('left (fecha,7) = ?', [$this->fecha])
                ->groupBy('user_id')
                ->with(['usuario.Banco','usuario.TipoCuenta'])->get();

            // Inicializar el array de bonos
            $data['bonos'] = [];
        }

        if(isset($this->tipos['depositos']) && $this->tipos['depositos']){
            $depositos = Deposito::selectRaw('user_id, sum(deposito_solicitado) as monto')
                ->whereRaw('left (fecha_para_deposito,7) = ?', [$this->fecha])
                ->where('estado', 'SOLICITADO')
                ->groupBy('user_id')
                ->with('Usuario')->get();

            // Inicializar el array de depositos
            $data['depositos'] = [];
        }

        foreach ($bonos as $bono) {
            $data['bonos'][$bono->user_id] = [
                'rut' => $bono->usuario->rut,
                'nombre' => $this->formatearNombrePersonal($bono->usuario->name . " " . $bono->usuario->apaterno . " " . $bono->usuario->amaterno),
                'monto' => $bono->monto,
                'banco' => $bono->usuario->Banco->codigo ?? '',
                'cuenta' => $this->formatearNombrePersonal($bono->usuario->TipoCuenta->nombre ?? '') ,
                'numero_cuenta' => $bono->usuario->nro_cuenta ?? '',
                'correo' => $bono->usuario->emailPersonal ?? '',
            ];
        }

        foreach ($depositos as $deposito) {
            $data['depositos'][$deposito->user_id] = [
                'rut' => $deposito->usuario->rut,
                'nombre' => $this->formatearNombrePersonal($deposito->usuario->name . " " . $deposito->usuario->apaterno . " " . $deposito->usuario->amaterno),
                'monto' => $deposito->monto,
                'banco' => $deposito->usuario->Banco->codigo ?? '',
                'cuenta' => $this->formatearNombrePersonal($deposito->usuario->TipoCuenta->nombre ?? ''),
                'numero_cuenta' => $deposito->usuario->nro_cuenta ?? '',
                'correo' => $deposito->usuario->emailPersonal ?? '',
            ];
        }
        return $data;
    }

    private function body()
    {
        $data = $this->query();

        // Procesar bonos si existen
        if (isset($data['bonos'])) {
            foreach ($data['bonos'] as $bono) {
                $row = [
                    $bono['rut'],
                    $bono['nombre'],
                    $bono['monto'],
                    'Abono en cuenta',
                    $bono['banco'],
                    $bono['cuenta'],
                    $bono['numero_cuenta'],
                $bono['correo'],
                'BONOS ', // Referencia Cliente
                'BONOS ', // Glosa Cartola Origen
                'BONOS ', // Glosa Cartola Destino
                'BONOS ', // Detalle de Pago
            ];
            $this->writer->addRow(WriterEntityFactory::createRowFromArray($row));
        }
        }

        // Procesar depósitos si existen
        if (isset($data['depositos'])) {
            foreach ($data['depositos'] as $deposito) {
                $row = [
                    $deposito['rut'],
                    $deposito['nombre'],
                    $deposito['monto'],
                    'Abono en cuenta',
                    $deposito['banco'],
                    $deposito['cuenta'],
                $deposito['numero_cuenta'],
                $deposito['correo'],
                'DEPOSITO ', // Referencia Cliente
                'DEPOSITO ', // Glosa Cartola Origen
                'DEPOSITO ', // Glosa Cartola Destino
                'DEPOSITO ', // Detalle de Pago
            ];
            $this->writer->addRow(WriterEntityFactory::createRowFromArray($row));
        }
    }
}


    public function download()
    {
        // Configurar límite de memoria para el proceso
        ini_set('memory_limit', '256M');

        $this->writer->openToBrowser('Contabilidad_' . $this->fecha . '.xlsx');
        $this->headers();
        $this->body();

        $this->writer->close();

        // Limpieza de memoria después de generar el archivo
        $this->colorStyles = [];
        $this->styleHeader = null;

        // Restaurar límite de memoria
        ini_set('memory_limit', '128M');
    }

    /**
     * Formatea un texto para que la primera letra de cada palabra esté en mayúscula
     *
     * @param string $texto El texto a formatear
     * @return string El texto formateado
     */
    private function formatearNombrePersonal($texto)
    {
        // Primero convertimos todo a minúsculas y luego la primera letra de cada palabra a mayúscula
        // Para asegurar que funcione con caracteres especiales de español, usamos mb_convert_case
        if (function_exists('mb_convert_case')) {
            return mb_convert_case(mb_strtolower(trim($texto), 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
        } else {
            // Fallback si no está disponible la extensión mbstring
            return ucwords(strtolower(trim($texto)));
        }
    }

}
