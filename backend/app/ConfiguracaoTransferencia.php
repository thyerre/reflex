<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\ConfiguracaoTransferencia as JobConfiguracaoTransferencia;
class ConfiguracaoTransferencia extends Model
{
    protected $table = "configuracao_transferencia";
    protected $primaryKey   = "id";
    protected $fillable = ["id", "id_data_warehouse", "obj_pacote_total", "obj_pacote_atual", "obj_key_atual", "ds_status", "dt_final", "bo_ativo", "bo_finalizado", "created_at", "updated_at"]; 

    public static function criarTranferencia($configuracao, $dataWareHouse)
    {   
        $con = self::setConfigDatabaseTransferencia(json_decode($dataWareHouse->host));

        $configuracaoTransferencia = new \App\ConfiguracaoTransferencia();
        $configuracaoTransferencia->id_data_warehouse = $dataWareHouse->id;
        $configuracaoTransferencia->obj_pacote_atual = self::setObjKeyAtual(json_decode($dataWareHouse->tabela), true);
        $configuracaoTransferencia->obj_pacote_total = self::initObjPacoteTotal(json_decode($dataWareHouse->tabela), $configuracao, $con);
        $configuracaoTransferencia->obj_key_atual = self::setObjKeyAtual(json_decode($dataWareHouse->tabela), true); 
        $configuracaoTransferencia->bo_ativo = true;
        $transferencia = $configuracaoTransferencia->save();
        return $transferencia;

    }

    public static function setObjKeyAtual($tabelas, $init = false)
    {
        $ar = [];
        foreach ($tabelas as $key => $value) {
            $ar[$key] = $init ? 0 : $value['id_atual'];
        }
        return json_encode($ar);
    }

    public static function initObjPacoteTotal($tabelas, $configuracao, $con)
    {
        $ar = [];
        foreach ($tabelas as $tabela => $colunas) {
            $ar[$tabela]  = self::getQuantidadePacotes($con, $tabela, $configuracao);
        }
        return json_encode($ar);
    } 

    public static function continuarTranferencia($configuracao, $dataWareHouse)
    {
        $conHost = self::setConfigDatabaseTransferencia(json_decode($dataWareHouse->host));
        $conServe = self::setConfigDatabaseTransferencia(json_decode($dataWareHouse->serve));
        $transferencia = self::pegarTranferencia($dataWareHouse->id);
        $objAtual = json_decode($transferencia->obj_pacote_atual);
        $objKey = json_decode($transferencia->obj_key_atual);
        $objTotal = json_decode($transferencia->obj_pacote_total);
        $tabelas = json_decode($dataWareHouse->tabela);
        $qtRegistrosPorPacotes = $configuracao->qt_registros;
        $arRetorno = [];

        foreach ($tabelas as $tabela => $valor) {
            $colunas = self::getTabelasComColunas($conServe, $tabela);
            for ($i=$objAtual->$tabela; $i < $objTotal->$tabela; $i++) {

                \DB::connection(json_decode($conHost))->beginTransaction();
                $registros = self::getRegistros($conHost, str_replace('_dw', '', $tabela), implode(',', array_column($colunas, 'Field')), $qtRegistrosPorPacotes, $objKey->$tabela);
                \DB::connection(json_decode($conHost))->commit();

                $pk = \App\DataWarehouse::getPk($conServe, $tabela);
                if ($registros) {
                    \DB::connection(json_decode($conServe))->beginTransaction();
                    \DB::connection($conServe)->table($tabela)->insert(self::format($registros));
                    \DB::connection(json_decode($conServe))->commit();
                    $arRetorno[$tabela] = (array) end($registros);
                } else {
                    $arRetorno[$tabela][$pk->COLUMN_NAME] =  $objKey->$tabela;
                }
                $arRetorno[$tabela]['id_atual'] = $arRetorno[$tabela][$pk->COLUMN_NAME] ?? $objKey->$tabela;


            }
        }

        return $arRetorno;
    }

    public static function finalizarTranferencia($dados, $dataWareHouse, $configuracao)
    {
        $configuracaoTransferencia = self::pegarTranferencia($dataWareHouse->id);
        $configuracaoTransferencia->obj_key_atual = self::setObjKeyAtual($dados); 
        $configuracaoTransferencia->save();

        $data = date('Y-m-d');
        if ($configuracao->bo_diario) {
            $data =  date('Y-m-d', strtotime("+1 days",strtotime($data))); 
        } else if ($configuracao->bo_semanal) {
            $data =  date('Y-m-d', strtotime("+7 days",strtotime($data))); 
        } else {
            $data =  date('Y-m-d', strtotime("+1 month",strtotime($data))); 
        }
        $job = (new \App\Jobs\ConfiguracaoTransferencia($configuracaoTransferencia->id));

        JobConfiguracaoTransferencia::dispatch($job)->delay(\App\Configuracao::setDelayByDataAndHora($data, $configuracao->hora));
    }

    public static function format($dados)
    {   
        $ar = [];
        foreach ($dados as $key => $value) {
            $ar[] = (array) $value;
        }

        return $ar;
    }

    public static function pegarTranferencia($id_data_warehouse)
    {
        
        $configuracaoTransferencia = \App\ConfiguracaoTransferencia::where("id_data_warehouse", "=", $id_data_warehouse)->orderBy("id", "desc")->limit(1)->get();

        if (isset($configuracaoTransferencia[0])) {
            return $configuracaoTransferencia[0];
        }
        return false;
    }

    public static function getTabelasComColunas($con, $table){
        $columns = \DB::connection($con)->select("DESCRIBE  {$table}");
        return $columns;
    }

    public static function getRegistros($con, $tabela, $colunas, $qt_registros, $id)
    {
        $pk = \App\DataWarehouse::getPk($con, $tabela);
        $sql = "SELECT {$colunas} FROM {$tabela} where {$pk->COLUMN_NAME} > {$id} limit {$qt_registros}";
        return \DB::connection($con)->select($sql);
    }

    public static function getQuantidadePacotes($con, $tabela, $configuracao)
    {
        
        $sql = "select count(*) as total from ". str_replace("_dw", "", $tabela);

        $count = \DB::connection($con)->select($sql)[0];

        $qtRegistros = $count->total;
        $qtPacotes = ($qtRegistros < $configuracao->qt_registros) ? 1 : ($qtRegistros / $configuracao->qt_registros);
        $qtPacotes =  ceil($qtPacotes);

        return $qtPacotes;
    }

    public static function setConfigDatabaseTransferencia($confDatabase){
        \Config::set("database.connections.{$confDatabase->no_database}", [
            'driver' => $confDatabase->driver,
            "host" => $confDatabase->host,
            "database" => $confDatabase->no_database,
            "username" => $confDatabase->usuario,
            "password" => $confDatabase->password
        ]);
        return $confDatabase->no_database;
    }

    public static function getInformacoesByTabelas($tabelas, $dataWareHouse){
        $tabelas = (array) $tabelas;
        $ar = [];
        $conHost = self::setConfigDatabaseTransferencia(json_decode($dataWareHouse->host));
        $conServe = self::setConfigDatabaseTransferencia(json_decode($dataWareHouse->serve));
        $index = 0;
        foreach ($tabelas as $tabela => $value) {
            $sql = "select count(*) as total from ". str_replace("_dw", "", $tabela);
            $total = \DB::connection($conHost)->select($sql)[0];

            $sql = "select count(*) as total from " . $tabela;
            $migrados = \DB::connection($conServe)->select($sql)[0];

            $ar[$index]['total'] = $total->total;
            $ar[$index]['migrados'] = $migrados->total;
            $ar[$index]['tabela'] = str_replace("_dw", "", $tabela);
            $ar[$index]['tabelaServe'] = $tabela;

            $porcentagem = ($total->total / 100) * $migrados->total;
            $ar[$index]['porcentagem'] = number_format($porcentagem, 2);
            $index++;
        }

        return $ar;
    }
    
} 
