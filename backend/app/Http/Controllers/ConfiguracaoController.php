<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use JWTAuth;

class ConfiguracaoController extends Controller
{
    // private $token;
    // private $confDatabase;
    public function __construct()
    {
        // $this->token = JWTAuth::parseToken()->authenticate();
        // $this->confDatabase = \App\DataWarehouse::setConfigDatabase();
    }
    
    public function index(){}

    public function getColumnsByTable($table){}

    public function getFKByTable($table){}

    public function store(Request $request){}
   
  

    public function show($id)
    {
        $configuracao =\App\Configuracao::find($id);
        
        if(!$configuracao){
            return response(["response"=>"Não existe Caixa Operacoes"],400);
        }
        if (!empty($configuracao->dt_inicial)) {
            $configuracao->dt_inicial = date("d/m/Y", strtotime($configuracao->dt_inicial));
        }
        return response($configuracao);
    }
    
    public function update(Request $request, $id){
        \DB::beginTransaction();
        $configuracao =  \App\Configuracao::find($id);
        
        if(!$configuracao){
            return response(['response'=>'configuracao Não encontrado'],400);
        }
        $configuracao = Helpers::processarColunasUpdate($configuracao,$request->all());
        if(!$configuracao->update()){
            return response(['response'=>'Erro ao alterar configuracao'],400);
        }
        
        $job = (new \App\Jobs\ConfiguracaoTransferencia($id))->delay(\App\Configuracao::setDelayByDataAndHora($configuracao->dt_inicial, $configuracao->hora));

        $this->dispatch($job);

        \DB::commit();
        return response(['response'=>'Atualizado com sucesso']);

    }

    public function getInformacoesAtualizacao($id)
    {
        $info = [];
        $dataWarehouse =  \App\DataWarehouse::find($id);
        $configuracao =  \App\Configuracao::find($id);
        $configuracaoTransferencia =  \App\ConfiguracaoTransferencia::pegarTranferencia($id);

        if(!$configuracao){
            return response(['response' => 'configuracao Não encontrado'],400);
        }

        if(!$configuracaoTransferencia){
            return response(['dados' => $info]);
        }

        $info = \App\ConfiguracaoTransferencia::getInformacoesByTabelas(json_decode($configuracaoTransferencia->obj_key_atual), $dataWarehouse);

        return response(['dados' => $info]);
    }
    

    public function destroy($id){}
}