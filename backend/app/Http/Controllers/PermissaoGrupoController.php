<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use JWTAuth;

class PermissaoGrupoController extends Controller
{
    private $token;
    public function __construct()
    {
        $this->token = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        $permissaoGrupo = \App\PermissaoGrupo::getPermissaoByEmpresa($this->token['id_empresa']);
        if (!$permissaoGrupo) {
            return response(["response" => "Não existe PermissaoGrupo"], 400);
        }
        return response(["dados" => $permissaoGrupo]);
    }


    public function store(Request $request)
    {
        $request['id_empresa'] = $this->token['id_empresa'];
        $permissaoGrupo = \App\PermissaoGrupo::create($request->all());
        if (!$permissaoGrupo) {
            return  response(["response" => "Erro ao salvar PermissaoGrupo"], 400);
        }
        return response(["response" => "Salvo com sucesso", 'dados' => $permissaoGrupo]);
    }

    public function checkPermission(Request $request)
    {

        $permissions = \App\PermissaoGrupo::checkPermission($request, $this->token);
        return [$permissions];
    }
    public function permissaogrupoupdate(Request $request, $id)
    {

        $permissaoGrupoRotina =  \App\GrupoPermissaoRotina::find($id);
        if ($permissaoGrupoRotina['id_empresa'] != $this->token['id_empresa']) {
            return response(['error' => "Não tem permissão para alterar esse PermissaoGrupo"], 400);
        }
        if (!$permissaoGrupoRotina) {
            return response(['response' => 'PermissaoGrupo Não encontrado'], 400);
        }
        $permissaoGrupoRotina = Helpers::processarColunasUpdate($permissaoGrupoRotina, $request->all());

        if (!$permissaoGrupoRotina->update()) {
            return response(['response' => 'Erro ao alterar'], 400);
        }
        return response(['response' => 'Atualizado com sucesso']);
    }

    public function show($id)
    {
        $permissaoGrupo = \App\PermissaoGrupo::find($id);
        $permissions = \App\PermissaoGrupo::getGrupoPermissaoRotinaByGrupo($permissaoGrupo->id, $this->token['id_empresa']);
        if (!$permissaoGrupo) {
            return response(["response" => "Não existe PermissaoGrupo"], 400);
        }
        // $ids = implode(',', array_map(function ($entry) {
        //     return $entry['id_grupo_permissao_rotina'];
        // }, (array)$permissions));

        $qtdInserido = \App\PermissaoGrupo::checkAndInsertMissingPermission($permissions,$permissaoGrupo->id,$this->token['id_empresa']);
        if($qtdInserido['qtdInserido'] >0){
            return $this->show($id);
        }


        return response([$permissaoGrupo, "permissions" => $permissions]);
    }
    


    public function update(Request $request, $id)
    {
        $permissaoGrupo =  \App\PermissaoGrupo::find($id);
        if ($permissaoGrupo['id_empresa'] != $this->token['id_empresa']) {
            return response(['error' => "Não tem permissão para alterar esse Grupo"], 400);
        }
        if (!$permissaoGrupo) {
            return response(['response' => 'PermissaoGrupo Não encontrado'], 400);
        }
        $permissaoGrupo = Helpers::processarColunasUpdate($permissaoGrupo, $request->all());

        if (!$permissaoGrupo->update()) {
            return response(['response' => 'Erro ao alterar'], 400);
        }
        return response(['response' => 'Atualizado com sucesso']);
    }


    public function destroy($id)
    {
        $permissaoGrupo =  \App\PermissaoGrupo::find($id);
        if ($permissaoGrupo['id_empresa'] != $this->token['id_empresa']) {
            return response(['error' => "Não tem permissão para alterar esse PermissaoGrupo"], 400);
        }
        if (!$permissaoGrupo) {
            return response(['response' => 'PermissaoGrupo Não encontrado'], 400);
        }
        $permissaoGrupo->bo_ativo = false;
        if (!$permissaoGrupo->save()) {
            return response(["response" => "Erro ao deletar PermissaoGrupo"], 400);
        }
        return response(['response' => 'PermissaoGrupo Inativado com sucesso']);
    }
}
