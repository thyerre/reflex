<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPermissao extends Model
{
    protected $table = "grupo_permissao";
    protected $primaryKey   = "id";
    protected $fillable = ['no_grupo_permissao','id_empresa','created_at','updated_at']; 
} 
