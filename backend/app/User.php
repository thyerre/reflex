<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // a consulta na hora de logar vem dessa tabela
    protected $table = "funcionario";
    protected $primaryKey   = 'id';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password','id_empresa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password','bo_fisico','no_pai','no_mae','id_dados_bancarios','vl_salario','porcentagem_comissao','tp_comissao','ds_observacao','created_at','updated_at','login',
    ];
    public function empresa()
    {
        return $this->hasOne('\App\Empresa');
    }
    public function user(){
        return 1;
    }
    
}
