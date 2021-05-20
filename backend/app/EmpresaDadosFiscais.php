<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaDadosFiscais extends Model
{
    protected $table = "empresa_dados_fiscais";
    protected $primaryKey   = "id";
    protected $fillable = ['aliquota_simples_nacional','aliquota_icms','aliquota_pis','aliquota_cofins','aliquota_bc_irpj','aliquota_irpj','aliquota_bc_csll','aliquota_csll','id_regime_tributario','id_empresa_atividade']; 

    // public function getUsuarioEmpresaByIdEmpresa($id){
    //     return  \DB::table('empresa')->select('*')
    //     ->where('id', $id)
    //     ->get()
    //     ->first();
    // }
} 
