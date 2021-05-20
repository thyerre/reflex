<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresa";
    protected $primaryKey   = "id";
    protected $fillable = ["no_fantasia","nu_cnpj","no_razao_social","nu_inscricao_estadual","nu_inscricao_municipal","id_empresa_dados_fiscais","img"]; 

    public function getEmpresaById($id){
        return  \DB::table('empresa')->select('*')
        ->where('id', $id)
        ->get()
        ->first();
    }
    
    // public static function getEmpresaByToken($token){
    //     $empresa = \App\Empresa::leftJoin('endereco', 'empresa.id_endereco', '=', 'endereco.id')
    //     ->leftJoin('log_localidade', 'endereco.id_cidade', '=', 'log_localidade.id')
    //     ->leftJoin('log_estado', 'log_localidade.id_log_estado', '=', 'log_estado.id')
    //     ->leftJoin('empresa_certificado', 'empresa_certificado.id_empresa', '=', 'empresa.id')
    //     ->leftJoin('empresa_dados_fiscais', 'empresa.id_empresa_dados_fiscais', '=', 'empresa_dados_fiscais.id')
    //     ->leftJoin('regime_tributario', 'regime_tributario.id', '=', 'empresa_dados_fiscais.id_regime_tributario')
    //     ->select(
    //         'empresa.*',
    //         // 'regime_tributario.*',
    //         'regime_tributario.CRT','regime_tributario.ds_regime_tributario',
    //         "endereco.nu_cep","endereco.ds_endereco","endereco.tp_endereco","endereco.no_bairro","endereco.no_complemento","endereco.id_cidade","endereco.nu_numero"
    //     ,'log_estado.id as id_estado','log_estado.uf','log_estado.ibge as cUF','log_localidade.ibge as cMunFG','log_localidade.nome','empresa_certificado.tp_certificado','empresa_certificado.file_certificado')
    //     ->where('empresa.id', $token['id_empresa'])
    //     ->get()
    //     ->first();
    //     if(!$empresa){
    //         return response(["response"=>"Não existe Empresa"],400);
    //     }
        
    //     $empresa_telefone = \App\EmpresaTelefone::getTelefoneByEmpresa($token['id_empresa']);
    //     $empresa_email = \App\EmpresaEmail::getEmailByEmpresa($token['id_empresa']);

    //     return [
    //         "empresa"=>$empresa,
    //         'empresa_telefone'=>$empresa_telefone,
    //         'empresa_email'=>$empresa_email,
    //         'atividades'=>self::getAtividades(),
    //         'regimesTributarios' => self::getRegimeTributarios(),
    //         'empresaDadosFiscais' => self::empresaDadosFiscais($token),
    //         'certificado' => \App\EmpresaCertificado::getDadosCertificateByEmpresa($token['id_empresa'])
    //         ];
    // }

    // public static function getAtividades(){
    //     return \DB::table('empresa_atividade')->get();
    // }
    // public static function getRegimeTributarios(){
    //     return \DB::table('regime_tributario')->get();
    // }
    // public static function empresaDadosFiscais($token){
    //     return \App\Empresa::leftJoin('empresa_dados_fiscais', 'empresa.id_empresa_dados_fiscais', '=', 'empresa_dados_fiscais.id')
    //     ->where('empresa.id', $token['id_empresa'])
    //     ->get()
    //     ->first();
    // }
} 
