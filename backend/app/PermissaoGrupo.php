<?php

namespace App;
use Helpers;
use Illuminate\Database\Eloquent\Model;

class PermissaoGrupo extends Model
{
    protected $table = "grupo_permissao";
    protected $primaryKey   = "id";
    protected $fillable = ['no_grupo_permissao', 'id_empresa','bo_ativo', 'created_at', 'updated_at'];

    public static function getPermissaoByEmpresa($token)
    {
        $funcionario = self::where('id_empresa', $token)->get();
        if (!$funcionario) {
            return response(["response" => "Não existe Funcionario"], 400);
        }
        return $funcionario;
    }
    public static function getGrupoPermissaoRotinaByGrupo($id_grupo, $token)
    {
        return \App\Rotina::leftJoin('grupo_permissao_rotina AS gpr', 'gpr.id_rotina', '=', 'tb_sistema_rotina.cd_sistema_rotina')
            ->leftJoin('grupo_permissao AS gp', 'gp.id', '=', 'gpr.id_grupo_permissao')
            ->select(
                'tb_sistema_rotina.*',
                'gpr.id as id_grupo_permissao_rotina',
                'gpr.id_rotina',
                'gpr.id_grupo_permissao',
                'gpr.bo_create',
                'gpr.bo_read',
                'gpr.bo_show',
                'gpr.bo_update',
                'gpr.bo_delete',
                'gp.no_grupo_permissao',
                'gp.id',
                'gp.id_empresa',
                'gp.bo_ativo'
            )
            ->where('gp.id', $id_grupo)
            ->where('gp.id_empresa', $token)
            ->get();
    }
    public static function checkPermission($route, $token)
    {
        $explodeRoute = explode("/", $route->route);
        $totalParametrosRota = Helpers::count($explodeRoute);
        $funcionario = \App\Funcionario::join("grupo_permissao as gp", 'gp.id', '=', 'funcionario.id_grupo_permissao')
            ->where('funcionario.id', $token['id'])
            ->get()->first();
        $superUser = ['admin', 'superadmin', 'administirador'];
        if (in_array(strtolower($funcionario->no_grupo_permissao), $superUser)) {
            return true;
        }
        $permissions = self::getGrupoPermissaoRotinaByGrupo($funcionario->id_grupo_permissao, $token['id_empresa']);
        foreach ($permissions as $key => $value) {
            if ($value->ds_url == $explodeRoute[0]) {
                if ($totalParametrosRota == 1) {
                    if ($value->bo_read) {
                        return true;
                    }
                } else if ($explodeRoute[1] == 'detalhar') {
                    if ($value->bo_show) {
                        return true;
                    }
                } else if ($explodeRoute[1] == 'incluir') {
                    if ($value->bo_create) {
                        return true;
                    }
                } else if ($explodeRoute[1] == 'alterar') {
                    if ($value->bo_update) {
                        return true;
                    }
                }
                return false;
            }
        }
        return false;
    }
    public static function getPermissoesByGrupo($id_grupo_permissao)
    {
        return self::where('id_grupo_permissao', $id_grupo_permissao)->get();
    }
    public static function checkAndInsertMissingPermission($permissions,$id_grupo_permissao,$tokenEmpresa)
    {
        $ids = [];
        foreach ($permissions as $key => $value) {
            $ids[] = $value->id_rotina;
        }
        $rotinasFaltando = \App\Rotina::whereNotIn('cd_sistema_rotina', $ids)->get();

        $qtdInserido =0;
        foreach ($rotinasFaltando as $key => $rotina) {
            $arRotina['id_rotina'] = $rotina->cd_sistema_rotina;
            $arRotina['id_grupo_permissao'] = $id_grupo_permissao;
            $arRotina['bo_create'] = 0;
            $arRotina['bo_read'] = 0;
            $arRotina['bo_show'] = 0;
            $arRotina['bo_update'] = 0;
            $arRotina['bo_delete'] = 0;
            $arRotina['id_empresa'] = $tokenEmpresa;
            \App\GrupoPermissaoRotina::create($arRotina);
            $qtdInserido++;
        }

        return ['qtdInserido'=>$qtdInserido];
    }
}
