<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public function Cargo(){
        return $this->belongsTo(Cargo::Class);
    }

   public function roles(){
        return $this->belongsToMany(Role::Class,'roles_users');
    }

    public function UsersClientes(){
        return $this->belongsToMany(Users_Clientes::Class,'users_clientes','user_id','clientes_id');
    }

    public function notifyroles(){
        return $this->belongsToMany(Notifyrole::class,'notifyroles_users');
    }

    public function hasRoles($role){
        foreach ($this->roles  as $userRole) {
            if (trim($userRole->name)===$role){
                return true;
            }
        }

      return false;
    }

    public function hasNotifyroles($notifyroles){
        foreach ($this->notifyroles  as $userRole) {
            if (trim($userRole->name)===$notifyroles){
                return true;
            }
        }
    return false;
}

    public function skills(){
        return $this->belongsToMany(Skill::Class,'skills_users');
    }

    public function herramientas(){
        return $this->belongsToMany(Herramienta::Class,'herramientas_users');
    }

    public function Comuna(){
        return $this->belongsTo(Comuna::class);
    }

    public function Empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function Afp(){
        return $this->belongsTo(Afp::class);
    }

    public function Banco(){
        return $this->belongsTo(Banco::class);
    }

    public function Prevision(){
        return $this->belongsTo(Prevision::class);
    }

    public function TipoContrato(){
        return $this->belongsTo(TipoContrato::class);
    }

    public function TipoCuenta(){
        return $this->belongsTo(TipoCuenta::class);
    }

    public function Proyecto(){
        return $this->belongsTo(Proyecto::class);
    }

    public function Actividades(){
        return $this->belongsToMany(Actividad::class,'users_actividades');
    }

     public function ActividadesDia($dia){
        return $this->Actividades()->where('fecha',$dia)->get();
    }


    public function ActividadSinDeposito(){
        return $this->Actividades()->where('deposito_solicitado','>',0)->where('deposito_depositado',null)->get();
    }

    public function Depositos(){
        return $this->hasMany(Deposito::class);
    }

    public function Anticipos(){
        return $this->hasMany(Anticipo::class);
    }

    public function DepositosPendientes(){
        return $this->Depositos()->where('deposito_solicitado','>',0)->where('deposito_depositado',null)->get();
    }

    public function Horas(){
        return $this->hasMany('\App\User_Actividad');
    }

    public function HorasDia($dia){
        return $this->Horas()->where('fecha',$dia)->orderBy('hora','asc')->get();
    }


    public function setRutAttribute($value){
        $this->attributes['rut'] = str_replace(".", "", $value);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
