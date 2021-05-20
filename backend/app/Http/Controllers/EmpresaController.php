<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use JWTAuth;
use App\Library\ConsultarCnpj;

class EmpresaController extends Controller
{
    private $token;

    public function __construct() 
    {
        $this->token = JWTAuth::parseToken()->authenticate();
    }
    
    public function index()
    {
        // return response(\App\Empresa::getEmpresaByToken($this->token));
    } 
    // public function findEmpresaByCnpj($cnpj){
    //     return ConsultarCnpj::find($cnpj);
    // }
    // public function getAtividades(){
    //     return \DB::table('empresa_atividade')->get();
    // }
    // public function getBoletoPagamentoMensalidade(){
    //     $ano = date('Y');
    //     $mes = date('n');
    //     $boleto = \DB::table('pagamento_sistema')
    //     ->where('id_empresa',$this->token['id_empresa'])
    //     ->where('bo_pago',0)
    //     ->whereRaw("MONTH(dt_validade) = {$mes}")
    //     ->whereRaw("YEAR(dt_validade) = {$ano}")
    //     ->get();

    //     return response(['dados'=>$boleto],200);
    // }
    // public function getRegimeTributarios(){
    //     return \DB::table('regime_tributario')->get();
    // }
    // public function getInfoContatoSagesc(){
    //     return response([["telefone"=>"(64) 99918-7173","nome"=>"Thyerre Rangel"],["telefone"=>"(64) 99996-7567","nome"=>"Kleber de Souza"]]);
    // }
    // public function empresaDadosFiscais(){
    //     return \App\Empresa::leftJoin('empresa_dados_fiscais', 'empresa.id_empresa_dados_fiscais', '=', 'empresa_dados_fiscais.id')
    //     ->where('empresa.id', $this->token['id_empresa'])
    //     ->get()
    //     ->first();
    // }
    // public function store(Request $request)
    // {
    //     if ($request->hasFile('fileimg') || $request->hasFile('fileCertificado')) {
    //         $arImg['file']            = $request->hasFile('fileimg') ? Helpers::saveFileGeneric($request->file('fileimg'),'empresa'):false;
    //         $arImg['fileCertificado'] = $request->hasFile('fileCertificado') ? Helpers::saveFileGeneric($request->file('fileCertificado'),'empresa'):false;
    //         return response(["response"=>"imagem movida com sucesso",'file'=>$arImg['file'],'fileCertificado'=>$arImg['fileCertificado']]);
            
    //     }else{
    //         return "false";
    //     }
    
    // }
    

    
    // public function mycompany()
    // {
    //     $empresa =\App\Empresa::find($this->token['id_empresa']);
    //     if(!$empresa){
    //         return response(["response"=>"Não existe Empresa"],400);
    //     }
    //     return response($empresa);
    // }

    // public function show($id)
    // {
    //     $empresa =\App\Empresa::find($id);
    //     if(!$empresa){
    //         return response(["response"=>"Não existe Empresa"],400);
    //     }
    //     return response($empresa);
    // }

    // public function update(Request $request)
    // {
        
    //         \DB::beginTransaction();
    //         $empresa =  \App\Empresa::find($this->token['id_empresa']);
    //         $request['id_empresa'] = $this->token['id_empresa'];
    //         $request['nu_cnpj'] =  Helpers::removerCaracteresEspeciaisEspacos($request['nu_cnpj']);
    //         $request['nu_cep'] =  Helpers::removerCaracteresEspeciaisEspacos($request['nu_cep']);
    //         if($empresa['id'] != $this->token['id_empresa']){
    //             return response(['error'=>"Não tem permissão para alterar esse Empresa"],400);
    //         }
    //         if(!$empresa){
    //             return response(['response'=>'Empresa Não encontrado'],400);
    //         }
           
    //         if(!$request['img']){
    //             $request['img'] = $empresa->img;
    //         }
            
    //         $empresa = Helpers::processarColunasUpdate($empresa,$request->all());
    //         // return  $empresa;
    //         // return $empresa;
    //         if(!$empresa->update()){
    //             return response(['response'=>'Erro ao alterar empresa'],400);
    //         }

    //         if(!$this->updateEndereco($request->all(),$empresa['id_endereco'])){
    //             return response(['response'=>'Erro ao alterar endereco empresa'],400); 
    //         }

    //         if(!$this->updateDadosFiscais($request->all(),$empresa['id_empresa_dados_fiscais'])){
    //             return response(['response'=>'Erro ao alterar dados fiscais'],400); 
    //         }
    //         $certificado= '';
    //         if($request['file_certificado']){
    //             if(!$this->updateCertificado($request->all())){
    //                 return response(['response'=>"Erro ao alterar o Certificado \n Certificado invalido ou senha incorreta"],400); 
    //             }
    //             $certificado = \App\EmpresaCertificado::getDadosCertificateByEmpresa($this->token['id_empresa']);
    //         }
            
    //         if(!$this->removePhoneMailByEmpresa($this->token['id_empresa'])){
    //             return response(['response'=>'Erro ao alterar'],400);
    //         }
            
    //         if(!$this->insertTelefone((array) $request['telefones'])){
    //             return response(['response'=>'Erro ao alterar telefone'],400);
    //         }
    //         // return $request['telefones'];
    //         if(!$this->insertEmail((array) $request['emails'])){
    //             return response(['response'=>'Erro ao alterar email'],400);
    //         }
            

    //         \DB::commit();
    //         return response(['response'=>'Atualizado com sucesso','certificado'=>$certificado]);
        
    // }

    // public function updateCertificado($ar){
    //     $ar['password'] = $ar['pass'];
    //     $dadosCertificado = \App\EmpresaCertificado::validarCertificado($ar['file_certificado'],$ar['password']);
    //     if($dadosCertificado['status']){
    //         $certificado = \App\EmpresaCertificado::where('empresa_certificado.id_empresa',$this->token['id_empresa'])->get()->first();
    //         if($certificado){
    //             if(!\App\EmpresaCertificado::where('empresa_certificado.id_empresa',$this->token['id_empresa'])->delete()){
    //                 \DB::rollBack();
    //                 return false;
    //             }
    //         }
            
    //         if(!\App\EmpresaCertificado::create($ar)){
    //             \DB::rollBack();
    //             return false;
    //         }
    //     }else{
    //         return false;
    //     }
    //     return true;
       
    // }
    // public function updateEndereco($ar,$id){
    //     $endereco =  \App\Endereco::find($id);
    //     $endereco = Helpers::processarColunasUpdate($endereco,$ar);
    //     // dd($endereco);
    //     if($endereco){
    //         if(!$endereco->update()){
    //             \DB::rollBack();
    //             return false;
    //         }
    //     }
    //     return true;
    // }
    // public function updateDadosFiscais($ar,$id){
    //     $dadosFiscais =  \App\EmpresaDadosFiscais::find($id);
    //     $dadosFiscal = Helpers::processarColunasUpdate($dadosFiscais,$ar);
    //     if($dadosFiscal){
    //         if(!$dadosFiscal->update()){
    //             \DB::rollBack();
    //             return false;
    //         }
    //     }
    //     return true;
    // }
    // public function insertTelefone($ar){
    //     $id_empresa = $this->token['id_empresa'];
    //     foreach ($ar as $key => $items) {
    //         $phone =  $items;
    //         $phone['nu_dd'] = substr($phone['nu_telefone'], 1, 2);
    //         $telefone = \App\Telefone::create($phone);
    //         if(!$telefone){
    //             \DB::rollBack();
    //             return false;
    //         }
    //         $empresaTelefone['id_empresa']  = $id_empresa;
    //         $empresaTelefone['id_telefone'] = $telefone->id;
    //         $empresaTelefone['bo_ativo']    = 1;
    //         // return $empresaTelefone;
    //         $EmpresaTelefone = \App\EmpresaTelefone::create($empresaTelefone);
    //         if(!$EmpresaTelefone){
    //             \DB::rollBack();
    //             return false;
    //         }
    //     }
    //     return true;
    // }
    // public function insertEmail($ar){
    //     $id_empresa = $this->token['id_empresa'];
    //     foreach ($ar as $key => $items) {
    //         $empresa_email =[];
    //         $mail =  $items;
    //         $email = \App\Email::create($mail);
    //         if(!$email){
    //             \DB::rollBack();
    //             return false;
    //         }
    //         $empresa_email['id_empresa'] = $id_empresa;
    //         $empresa_email['id_email']   = $email->id;
    //         $empresa_email['bo_ativo']   = true;
    //         $empresaEmail = \App\EmpresaEmail::create($empresa_email);
    //         if(!$empresaEmail){
    //             \DB::rollBack();
    //             return false;
    //         }
    //     }
    //     return true;
    // }
    // public function removePhoneMailByEmpresa($id_empresa){
    //     if(!$this->deleteTelefoneEmpresaAndInsertAgain($id_empresa)){
    //         \DB::rollBack();
    //         return false;
    //     }
    //     if(!$this->deleteEmailEmpresaAndInsertAgain($id_empresa)){
    //         \DB::rollBack();
    //         return false;
    //     }
    //     return true;
    // }

    // public function deleteTelefoneEmpresaAndInsertAgain($id_empresa){
    //     $empresaTelefone = \App\EmpresaTelefone::where('id_empresa', $id_empresa)->get();
    //     \App\EmpresaTelefone::where('id_empresa', $id_empresa)->delete();
    //     foreach ($empresaTelefone as $key => $empresatelefone_value) {
    //         \App\Telefone::where('id', $empresatelefone_value['id_telefone'])->delete();
    //     }
    //     return true;
    // }
    // public function deleteEmailEmpresaAndInsertAgain($id_empresa){
    //     $empresaEmail = \App\EmpresaEmail::where('id_empresa', $id_empresa)->get();
    //     \App\EmpresaEmail::where('id_empresa', $id_empresa)->delete();
    //     foreach ($empresaEmail as $key => $empresaEmail_value) {
    //         \App\Email::where('id', $empresaEmail_value['id_Email'])->delete();
    //     }
    //     return true;
    // }

    // public function removerCertificado()
    // {
    //     $certificado = \App\EmpresaCertificado::where('empresa_certificado.id_empresa',$this->token['id_empresa'])->get()->first();
    //     if($certificado){
    //         if(\App\EmpresaCertificado::where('empresa_certificado.id_empresa',$this->token['id_empresa'])->delete()){
    //             return response(['response'=>'Certificado removido com sucesso'],200);
    //         }
    //     }
    //     return response(['response'=>'Certificado Não encontrado'],400);
    // }
    // public function destroy($id)
    // {
    //     $empresa =  \App\Empresa::find($id);
    //     if($empresa['id'] != $this->token['id_empresa']){
    //         return response(['error'=>"Não tem permissão para alterar esse Empresa"],400);
    //     }
    //     if(!$empresa){
    //         return response(['response'=>'Empresa Não encontrado'],400);
    //     }
    //     $empresa->bo_ativo = false;
    //     if(!$empresa->save()){
    //         return response(["response"=>"Erro ao deletar Empresa"],400);
    //     }
    //     return response(['response'=>'Empresa Inativado com sucesso']);
    // }

    
    
    // public function geocode($endereco){
    //     $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$endereco&key=AIzaSyCoR3VCFGP4jbsbkaQKylAh7V0YSq-nTZk");
    //     return json_decode($geocode, true);
    // }
}