<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rotina extends Model
{
    protected $table = "tb_sistema_rotina";
    protected $primaryKey   = 'cd_sistema_rotina';
    protected $fillable = ['cd_sistema_modulo','no_rotina','ds_rotina ','no_arquivo','ds_url ','icon'];
}
