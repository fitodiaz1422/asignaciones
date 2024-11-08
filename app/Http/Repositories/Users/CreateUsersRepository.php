<?php
namespace App\Http\Repositories\Users;

use Intervention\Image\Facades\Image;
use App\User;
use App\Uranoapp\CambioPrecios\Models\CambioPrecio;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\File;

class CreateUsersRepository
{
    public function store(array $data) : User
    {
        $user=new User;
        $user->imagen=$this->setImage(($data['imagen']) ?? null,$data['rut']);
        $user->email=$data['email'];
        $user->password=bcrypt($data['password']);
        $user->rut=$data['rut'];
        $user->name=strtoupper($data['name']);
        $user->apaterno=strtoupper($data['apaterno']);
        $user->amaterno=strtoupper($data['amaterno']);
        $user->fechaNacimiento=$data['fechaNacimiento'];
        $user->sexo=$data['sexo'];
        $user->estado_civil=$data['estado_civil'];
        $user->nacionalidad=$data['nacionalidad'];
        $user->comuna_id=$data['comuna_id'];
        $user->direccion=$data['direccion'];
        $user->fono=$data['fono'];
        $user->emailPersonal=$data['emailPersonal'];
        $user->banco_id=$data['banco_id'];
        $user->tipo_cuenta_id=$data['tipo_cuenta_id'];
        $user->nro_cuenta=$data['nro_cuenta'];
        $user->contacto_nombre=$data['contacto_nombre'];
        $user->contacto_fono=$data['contacto_fono'];
        $user->titulo_profesional=$data['titulo_profesional'];
        $user->institucion_estudio=$data['institucion_estudio'];
        $user->empresa_id=$data['empresa_id'];
        $user->proyecto_id=$data['proyecto_id'];
        $user->funcion=$data['funcion'];
        $user->fechaIngreso=$data['fechaIngreso'];
        $user->estado_contrato=$data['estado_contrato'];
        $user->tipo_contrato_id=$data['tipo_contrato_id'];
        $user->sueldo_establecido=$data['sueldo_establecido'];
        $user->sueldo_base=$data['sueldo_base'];
        $user->horas_semanales=$data['horas_semanales'];
        $user->colacion=$data['colacion'];
        $user->dias_vacaciones=$data['dias_vacaciones'];
        $user->gratificacion=$data['gratificacion'];
        $user->afp_id=$data['afp_id'];
        $user->cotizacion_especial=$data['cotizacion_especial'];
        $user->tramo_asignacion=$data['tramo_asignacion'];
        $user->jubilado=$data['jubilado'];
        $user->cargas=($data['cargas']) ?? 0;
        $user->seguro_cesantia=$data['seguro_cesantia'];
        $user->seguro_accidentes=$data['seguro_accidentes'];
        $user->prevision_id=$data['prevision_id'];
        $user->tipo_pacto_isapre=$data['tipo_pacto_isapre'];
        $user->monto_pactado=$data['monto_pactado'];
        $user->moneda_ges=$data['moneda_ges'];
        $user->monto_ges=$data['monto_ges'];
        $user->trabajador_joven=$data['trabajador_joven'];
        $user->cargo_id=$data['cargo_id'];

        if(isset($data['user_cliente']))
        {
            $user->usuario_cliente = "SI";

        }




        $user->save();
        $this->attachRoles($user,($data['roles']) ?? null);
        $this->attachNotifications($user,($data['notifications']) ?? null);
        $this->attachSkills($user,($data['skills']) ?? null);
        $this->attachHerramientas($user,($data['herramientas']) ?? null);

        if(isset($data['user_cliente']))
        {
         $this->attachUsersClientes($user,($data['cliente_user']) ?? null);
        }    

       



        return $user;
    }

    public function update(User $user,array $data) : User
    {
        //dd($this->setImage(($data['imagen']),$user->rut));
        $user->rut=$data['rut'];
        $user->name=strtoupper($data['name']);
        $user->apaterno=strtoupper($data['apaterno']);
        $user->amaterno=strtoupper($data['amaterno']);
        $user->fechaNacimiento=$data['fechaNacimiento'];
        $user->sexo=$data['sexo'];
        $user->estado_civil=$data['estado_civil'];
        $user->nacionalidad=$data['nacionalidad'];
        $user->comuna_id=$data['comuna_id'];
        $user->direccion=$data['direccion'];
        $user->fono=$data['fono'];
        $user->emailPersonal=$data['emailPersonal'];
        $user->banco_id=$data['banco_id'];
        $user->tipo_cuenta_id=$data['tipo_cuenta_id'];
        $user->nro_cuenta=$data['nro_cuenta'];
        $user->contacto_nombre=$data['contacto_nombre'];
        $user->contacto_fono=$data['contacto_fono'];
        $user->titulo_profesional=$data['titulo_profesional'];
        $user->institucion_estudio=$data['institucion_estudio'];
        $user->empresa_id=$data['empresa_id'];
        $user->proyecto_id=$data['proyecto_id'];
        $user->funcion=$data['funcion'];
        $user->fechaIngreso=$data['fechaIngreso'];
        $user->estado_contrato=$data['estado_contrato'];
        $user->tipo_contrato_id=$data['tipo_contrato_id'];
        $user->sueldo_establecido=$data['sueldo_establecido'];
        $user->sueldo_base=$data['sueldo_base'];
        $user->horas_semanales=$data['horas_semanales'];
        $user->colacion=$data['colacion'];
        $user->dias_vacaciones=$data['dias_vacaciones'];
        $user->gratificacion=$data['gratificacion'];
        $user->afp_id=$data['afp_id'];
        $user->cotizacion_especial=$data['cotizacion_especial'];
        $user->tramo_asignacion=$data['tramo_asignacion'];
        $user->jubilado=$data['jubilado'];
        $user->cargas=($data['cargas']) ?? 0;
        $user->seguro_cesantia=$data['seguro_cesantia'];
        $user->seguro_accidentes=$data['seguro_accidentes'];
        $user->prevision_id=$data['prevision_id'];
        $user->tipo_pacto_isapre=$data['tipo_pacto_isapre'];
        $user->monto_pactado=$data['monto_pactado'];
        $user->moneda_ges=$data['moneda_ges'];
        $user->monto_ges=$data['monto_ges'];
        $user->trabajador_joven=$data['trabajador_joven'];
        $user->cargo_id=$data['cargo_id'];
        if(isset($data['user_cliente']))
        {
            $user->usuario_cliente = "SI";

        }
        else{
            $user->usuario_cliente = null;

        }
        if(isset($data['imagen']))
            $user->imagen=$this->setImage(($data['imagen']),$user->rut);
        $user->save();
        $this->syncRoles($user,($data['roles']) ?? null);
        $this->syncNotifications($user,($data['notifications']) ?? null);
        $this->syncSkills($user,($data['skills']) ?? null);
        $this->syncHerramientas($user,($data['herramientas']) ?? null);
        $this->syncUsersClientes($user,($data['cliente_user']) ?? null);
        



        \Artisan::call('view:clear');
        return $user;
    }

    public function self_update(User $user,array $data) : User
    {
        $user->name=$data['name'];
        $user->apaterno=$data['apaterno'];
        $user->amaterno=$data['amaterno'];
        $user->fechaNacimiento=$data['fechaNacimiento'];
        $user->sexo=$data['sexo'];
        $user->estado_civil=$data['estado_civil'];
        $user->nacionalidad=$data['nacionalidad'];
        $user->comuna_id=$data['comuna_id'];
        $user->direccion=$data['direccion'];
        $user->fono=$data['fono'];
        $user->emailPersonal=$data['emailPersonal'];
        $user->banco_id=$data['banco_id'];
        $user->tipo_cuenta_id=$data['tipo_cuenta_id'];
        $user->nro_cuenta=$data['nro_cuenta'];
        $user->contacto_nombre=$data['contacto_nombre'];
        $user->contacto_fono=$data['contacto_fono'];
        $user->titulo_profesional=$data['titulo_profesional'];
        $user->institucion_estudio=$data['institucion_estudio'];
        if(isset($data['imagen']))
            $user->imagen=$this->setImage(($data['imagen']),$user->rut);
        $user->save();
        \Artisan ::call('view:clear');
        return $user;
    }


    public function updatePassword(User $user,$password) : User
    {
        $user->password=bcrypt($password);
        $user->save();
        return $user;
    }

    public function setImage(UploadedFile $image=null,$name)
    {
        $rutaimg="public/avatars/avatar.png";
        if($image){
            $ext=$image->extension();
            $image->storeAs('public/avatars', $name.".".$ext);
            $rutaimg='public/avatars/'.$name.".".$ext;
        }
        return $rutaimg;
    }

    public function syncRoles(User $user,$roles){
        $user->roles()->sync($roles);
    }

    public function syncUsersClientes(User $user,$users_clientes){
        $user->UsersClientes()->sync($users_clientes);
    }

    public function syncNotifications(User $user,$notifications){
        $user->notifyroles()->sync($notifications);
    }

    public function syncSkills(User $user,$skills){
        $user->skills()->sync($skills);
    }

    public function syncHerramientas(User $user,$herramientas){
        $user->herramientas()->sync($herramientas);
    }

    public function attachRoles(User $user,$roles){
        $user->roles()->attach($roles);
    }

    public function attachNotifications(User $user,$notifications){
        $user->notifyroles()->attach($notifications);
    }

    public function attachSkills(User $user,$skills){
        $user->skills()->attach($skills);
    }

    public function attachUsersClientes(User $user,$users_clientes){
        $user->UsersClientes()->attach($users_clientes);
    }

    public function attachHerramientas(User $user,$herramientas){
        $user->herramientas()->attach($herramientas);
    }

}
