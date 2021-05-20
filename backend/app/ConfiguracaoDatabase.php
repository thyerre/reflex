<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoDatabase extends Model
{
    protected $table = "configuracao_database";
    protected $primaryKey   = "id";
    protected $fillable = ["no_database", "driver", "usuario", "password", "host", "port", "charset"]; 

} 
