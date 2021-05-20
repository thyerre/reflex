<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataWarehouse extends Model
{
    protected $table = "data_warehouse";
    protected $primaryKey   = "id";
    protected $fillable = ['host','serve','ddl','tabela','join','no_data_warehouse','ds_data_warehouse','created_at','updated_at']; 

    private $columns = [];
    private $conHost;
    private $conServe;
    private $selectTable;
    private $tablesSelected;
    private $arComandoLigacoes;

    public function __construct( $init = false)
    {
        if ($init) {
            $this->conServe = self::setConfigDatabase('serve')->no_database;
            $this->conHost = self::setConfigDatabase('host')->no_database;
        }
    }

    public static function getTablesAndColunas($confDatabase){
        $con = $confDatabase->no_database;
        $tables =  \DB::connection($con)->getDoctrineSchemaManager()->listTableNames();
        $arTables = self::formatTables($tables);
        return $arTables;
    }

    public static function getFKByTable($confDatabase,$table){
        $con = $confDatabase->no_database;
        return  \DB::connection($con)->select(" SELECT REFERENCED_TABLE_NAME as tables FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = '{$table}' and REFERENCED_TABLE_NAME is not null group by REFERENCED_TABLE_NAME");
    }

    public static function setConfigDatabase($type = 'host'){
        $confDatabase = \App\ConfiguracaoDatabase::where('type', $type)->first();
        \Config::set("database.connections.{$confDatabase->no_database}", [
            'driver' => $confDatabase->driver,
            "host" => $confDatabase->host,
            "database" => $confDatabase->no_database,
            "username" => $confDatabase->usuario,
            "password" => $confDatabase->password,
            "charset" => $confDatabase->charset
        ]);
        return $confDatabase;
    }
    
    public static function getColunasByTabela($confDatabase, $table){
        $con = $confDatabase->no_database;
        $columns = \DB::connection($con)->select("DESCRIBE  {$table}");
        return self::formatColumns($columns, $table);
    }

    public static function formatTables($tables){
        $ar = [];
        foreach ($tables as $key => $tabela) {
            $ar[$key]['name'] = $tabela;
            $ar[$key]['select'] = false;
            $ar[$key]['delete'] = false;
            $ar[$key]['primary'] = false;
            $ar[$key]['fk_select'] = false;
        }
        return $ar;
    }

    public static function formatColumns($columns, $table){
        $ar = [];
        $cont = 0;
        foreach ($columns as $key => $column) {
            $ar[$cont]['field'] = $column->Field;
            $ar[$cont]['type'] = $column->Type;
            // $ar[$cont]['null'] = $column->Null;
            $ar[$cont]['key'] = $column->Key;
            $ar[$cont]['select'] = false;
            $ar[$cont]['table'] = $table;
            $cont++;
        }
        return $ar;
    }
    public static function formatTableAndColumns($dados) {
        $arTables = [];
        foreach ($dados as $key => $value) {
            $arTables[$value['table']][] = $value;
        }
        return $arTables;
    }
    public function dropTables($tables) {
        foreach ($tables as $table => $value) {
            Schema::connection($this->conServe)->dropIfExists($table."_dw");
        }
    }

    public function getSqlDDL($table) {
        return "show create table {$table}";
    }

    public function getDDLTables($tabelas) {
        $arDDLs = [];
        foreach ($tabelas as $tabela => $colunas) {
            $arDDLs[] = \DB::connection($this->conServe)->select($this->getSqlDDL($tabela))[0];
        }
        return $arDDLs;
    }

    public function formatarTabelasParaJoin($tabelas) {
        $ar = [];
        foreach ($tabelas as $tabela) {
            $ar[$tabela['name']] = $tabela;
        }
        return $ar;
    }

    public function formatarColunasParaJoin($colunas) {
        $ar = [];
        foreach ($colunas as $coluna) {
            $ar[$coluna['table']][] = $coluna;
        }
        return $ar;
    }

    public function getJoin($tabelas, $TabelasAndColunas) {
        $join["from"] = [];
        $primary = "";
        $tabelas = $this->formatarTabelasParaJoin($tabelas);
        $colunas = $this->gerarColunasJoin($TabelasAndColunas);
        foreach ($tabelas as $key => $table) {
            if ($table['primary']) {
                $primary = $key;
                $pk = self::getPk($this->conHost, $table['name']);
                $colunas .= ", {$table['name']}.{$pk->COLUMN_NAME} as '{$table['name']}.{$pk->COLUMN_NAME}'";
                continue;
            }
            $pkDaFk = self::getPk($this->conHost, $table['name']);
            $fkDaPk = $this->getColunaFk($this->conHost, $table['name'], $table['fk']);

            $colunas .= ", {$table['name']}.{$pkDaFk->COLUMN_NAME} as '{$table['name']}.{$pkDaFk->COLUMN_NAME}', {$table['fk']}.{$fkDaPk->COLUMN_NAME} as '{$table['fk']}.{$fkDaPk->COLUMN_NAME}'";

            $join[] = "left join {$table['name']} on({$table['name']}.{$pkDaFk->COLUMN_NAME}={$table['fk']}.{$fkDaPk->COLUMN_NAME})";
        }
        $join['from'] = "select {$colunas} from {$primary}";
        return implode(" ", $join);
    }

    public function getColunaFk($con, $tablePK, $tableFK) {
        $coluna = \DB::connection($con)->select("SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE kcu WHERE TABLE_NAME = '{$tableFK}' AND REFERENCED_TABLE_NAME = '{$tablePK}' AND TABLE_SCHEMA = '{$con}'");        
        if ($coluna) {
            return $coluna[0];
        }
        return false;
    }

    public function gerarColunasJoin($arTabelasAndColunas) {
        $arColunas = [];
       foreach ($arTabelasAndColunas as $key => $colunas) {
            foreach (array_column($colunas, "field") as $value) {
                $arColunas[] = " $key.$value as '$key.$value'";
            }
       }

       return implode(",", $arColunas);
    }

    public function generateLigacoes(){
        $arPK = [];
        $arFK = [];
        if (!$this->arComandoLigacoes) {
            return [];
        }
        foreach ($this->arComandoLigacoes as $key => $sql) {
            if (strpos($sql, "PRIMARY") !== false) {
                $arPK[] = $sql;
            } else {
                $arFK[] = $sql;
            }
        }
        $ar = array_merge($arPK, $arFK);
       foreach ($ar as $sql) {
            \DB::connection($this->conServe)->select($sql);
       }
       return $ar;
    }

    public function generateTables($tables, $tablesSelected){
        $result = [];
        $newTables = [];
        // $this->dropTables($tables);
        krsort($tables);

        foreach ($tables as $table => $columns) {
            $this->columns = $columns;
            $this->selectTable = $table;
            $this->tablesSelected = $tablesSelected;
            $tableDW = $table."_dw";
            $newTables[$tableDW] = array_column($columns, "field");

            if (self::tabelaExiste($this->conServe, $tableDW)) {
                continue;
            }

            $result = Schema::connection($this->conServe)->create($tableDW, function (Blueprint $ObjTable) {
                $pk = self::getPk($this->conHost, $this->selectTable);

                if ($pk) {
                    $existPK = self::checkExistPk($this->columns, $pk);
                    if (!$existPK) {
                        $ObjTable->integer($pk->COLUMN_NAME);
                        $this->arComandoLigacoes[] = "ALTER TABLE {$this->selectTable}_dw ADD CONSTRAINT PK_{$this->selectTable}_dw PRIMARY KEY ({$pk->COLUMN_NAME})";
                    }
                }
                
                foreach ($this->columns as $key => $column) {
                    $columnInfo = $this->traduzirTipo($column['type']);
                    $ObjTable->addColumn($columnInfo['type'], $column['field'], $columnInfo['params'])->nullable();
                }
                $ObjTable = $this->montarFK($ObjTable);
            });
        }

        return $result == null ? $newTables : false;
    }

    public static function tabelaExiste($con, $table){
        $existe = \DB::connection($con)->select("SHOW TABLES LIKE '{$table}'");
        if ($existe) {
            return true;
        }
        return false;
    }

    public static function traduzirTipo($tipo){
        if (!str_contains($tipo, '(')) {
            return ['type' => $tipo, "params" => []];
        }
        if (str_contains($tipo, 'decimal')) {
            $type = strstr($tipo, '(', true);
            $numbers = str_replace([$type, ')', '('], '', $tipo);
            $numbers = explode( ',', $numbers);

            return ['type' => $type, "params" => ["total" => $numbers[0], "places" => $numbers[1]]];
        }
        return ['type' => strstr($tipo, '(', true), "params" => []];
    }

    public function montarFK($ObjTable){
        $tableFK = $this->getFKAndColumns($this->conHost, $this->selectTable, $this->tablesSelected);

        foreach ($tableFK as $fk) {
            if(!in_array($fk->columns, array_column($this->columns, 'field'))){
                $ObjTable->integer($fk->columns);
                $this->arComandoLigacoes[] = "ALTER TABLE {$this->selectTable}_dw ADD FOREIGN KEY ({$fk->columns}) REFERENCES {$fk->tables}_dw({$fk->ref_column})";
            }
        }
        return $ObjTable;
    }
    
    public function getFKAndColumns($con, $table, $tablesSelected){
        $in = implode("','", array_column($tablesSelected, 'name'));
        $fks =  \DB::connection($con)->select(
            "SELECT REFERENCED_TABLE_NAME as tables, COLUMN_NAME as columns, REFERENCED_COLUMN_NAME as ref_column, REFERENCED_TABLE_NAME as ref_table
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = '{$table}' and REFERENCED_TABLE_NAME is not null 
            and REFERENCED_TABLE_NAME in('{$in}') 
            group by REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME, COLUMN_NAME, REFERENCED_TABLE_name;"
        );

        return $fks;
    }

    public static function getPk($con, $table){
        $pk =  \DB::connection($con)->select("SELECT COLUMN_NAME FROM information_schema.COLUMNS t where TABLE_NAME = '{$table}' and DATA_TYPE = 'int' and COLUMN_KEY = 'PRI'");
        if (!$pk) {
            return false;
        }
        return $pk[0];
    }

    public static function isPrimaryTable($tablesSelected, $table){
        foreach ($tablesSelected as $tableSelect) {
            if($tableSelect['name'] == $table && $tableSelect['primary']){
                return true;
            }
        }
        return false;
    }

    public static function checkExistPk($columns, $pk){
        foreach ($columns as $column) {
            if($column == $pk->COLUMN_NAME){
                return true;
            }
        }
        return false;
    }

    // public static function getDDLTables($confDatabase, $dados){
    //     $con = $confDatabase->no_database;
    //     foreach ($dados as $key => $value) {
    //             $ddl = self::getDDLByTable($con, $key);
    //     }
    // }

    // public static function getDDLByTable($con, $table){
    //     return  \DB::connection($con)->select(" SELECT REFERENCED_TABLE_NAME as tables FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = '{$table}' and REFERENCED_TABLE_NAME is not null group by REFERENCED_TABLE_NAME");
    // }
    
} 
