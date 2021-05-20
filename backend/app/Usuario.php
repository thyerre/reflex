<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "usuario";
    protected $primaryKey   = 'id';
    protected $fillable = [
        'login', 'password',
    ];
    public static function userLogado(){
        return \JWTAuth::parseToken()->authenticate();
    }
}
