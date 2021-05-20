<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPermissaoRotina extends Model
{
    protected $table = "grupo_permissao_rotina";
    protected $primaryKey   = "id";
    protected $fillable = ['id_rotina','id_grupo_permissao','bo_create','bo_read','bo_update','bo_show','id_empresa','bo_delete']; 

    
    public static function getPermissaoUser($token){
        $funcionario = \App\Funcionario::join('grupo_permissao','grupo_permissao.id','=','funcionario.id_grupo_permissao')
        ->select('funcionario.no_funcionario','grupo_permissao.id','grupo_permissao.no_grupo_permissao','funcionario.id_grupo_permissao')
        ->where('funcionario.id_empresa', $token['id_empresa'])->get()->first();
        if(!$funcionario){
            return response(["response"=>"Não existe Funcionario"],400);
        }
        return $funcionario;
    }
    
    public static function getPermissoesByGrupo($id_grupo_permissao){
        return self::where('id_grupo_permissao', $id_grupo_permissao)->get();
    }

} 
