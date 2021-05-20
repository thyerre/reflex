<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use JWTAuth;

class DataWarehouseController extends Controller
{
    private $token;
    private $confDatabase;
    public function __construct()
    {
        $this->token = JWTAuth::parseToken()->authenticate();
        $this->confDatabase = \App\DataWarehouse::setConfigDatabase();
    }
    
    public function index()
    {
        $dataWarehouse = \App\DataWarehouse::join('configuracao', 'configuracao.id_data_warehouse', '=', 'data_warehouse.id')
        ->select(
            "data_warehouse.*",
            "bo_diario",
            "bo_semanal",
            "bo_mensal",
            "dt_inicial",
            "hora"
        )
        ->get();
        if(!$dataWarehouse){
            return response(["response"=>"Não existe data warehouse"],400);
        }
        return response($dataWarehouse);
    }

    public function getTables()
    {
        $tables = \App\DataWarehouse::getTablesAndColunas($this->confDatabase);
        if(!$tables){
            return response(["response"=>"Não existe tables"],400);
        }
        return response($tables);
    }
    

    public function getColumnsByTable($table)
    {
        $tables = \App\DataWarehouse::getColunasByTabela($this->confDatabase,$table);
        if(!$tables){
            return response(["response"=>"Não foi encontrado colunas para essa tabela {$table}"],400);
        }
        return response($tables);
    }

    public function getFKByTable($table)
    {
        $fks = \App\DataWarehouse::getFKByTable($this->confDatabase,$table);
        if(!$fks){
            return response(["response"=>"não foi encontrado FK nessa tabela {$table}"],400);
        }
        return response($fks);
    }

    public function store(Request $request){
        $dataWarehouse = new \App\DataWarehouse(true);
        $tablesFormated = $dataWarehouse->formatTableAndColumns($request['columns']);
        $arCreateTable = $dataWarehouse->generateTables($tablesFormated, $request['tables']);
        $ligacoes = $dataWarehouse->generateLigacoes();

        if (!$arCreateTable) {
            return response(["response"=>"Não foi possivel criar o Data Warehouse, verifique o server do banco de dados!"],400);
        }

        $dataWarehouse->tabela = json_encode($arCreateTable);
        $dataWarehouse->ddl = json_encode($dataWarehouse->getDDLTables($arCreateTable));
        // $dataWarehouse->join = $dataWarehouse->getJoin($request['tables'], $tablesFormated);
        $dataWarehouse->serve = json_encode($dataWarehouse::setConfigDatabase('serve'));
        $dataWarehouse->host = json_encode($dataWarehouse::setConfigDatabase('host'));
        $dataWarehouse->no_data_warehouse =$request->no_data_warehouse;
        $dataWarehouse->ds_data_warehouse =$request->ds_data_warehouse;
        
        
        $dw = $dataWarehouse->save();

        if (!$dw) {
            return response(["response"=>"Não foi possivel criar o Data Warehouse, verifique o server do banco de dados!"],400);
        }

        $conf = \App\Configuracao::create(['id_data_warehouse' => $dataWarehouse->id]);

        if (!$conf) {
            return response(["response"=>"Não foi possivel criar o Data Warehouse, verifique o server do banco de dados!"],400);
        }
        return $dataWarehouse->getAttributes();
       
    }
   
  

    public function show($id){}
    
    public function update(Request $request, $id){}
    

    public function destroy($id){}
}