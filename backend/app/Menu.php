<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "tb_sistema_modulo";
    protected $primaryKey   = 'cd_sistema_modulo';
    protected $fillable = ['no_modulo','icone','bo_ativo'];
}
