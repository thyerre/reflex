<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = "configuracao";
    protected $primaryKey   = "id_data_warehouse";
    protected $fillable = ["id_data_warehouse", "bo_diario", "bo_semanal", "bo_mensal", "dt_inicial", "qt_registros", "hora", "bo_ativo", "created_at", "updated_at"]; 

    public static function setDelayByDataAndHora($data, $hora)
    {
        $dataHoraAtual = date("Y-m-d H:i");
        $dataHora = implode('-', array_reverse(explode('/', $data)));
        $dataHora = $dataHora. " " . $hora;

        $d1 = strtotime($dataHora); 
        $d2 = strtotime($dataHoraAtual);

        $diferencaEmSegundos = ($d1 - $d2);

        return $diferencaEmSegundos;
    }

} 
