<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Helpers;
use JWTAuth;

class FuncionarioController extends Controller
{
    private $token;
    public function __construct()
    {
        $this->token = JWTAuth::parseToken()->authenticate();
    }
    
    public function index()
    {
        $query = \App\Funcionario::query();
        $query = $query->where('id_empresa', $this->token['id_empresa']);
        $query = Helpers::searchWhere($query,__CLASS__,Input::get('search'));  
        
        if(!$funcionario = $query->get()){
            return response(["response"=>"Não existe Funcionario"],400);
        }
        return response(["dados"=>$funcionario]);
    }
    
    public function store(Request $request)
    {
        if ($request->hasFile('fileimg')) {
            if($img = Helpers::salveFile($request,'funcionario')){
                return response(["response"=>"imagem movida com sucesso",'file'=>$img['file']]);
            }   
        }else{
            \DB::beginTransaction();
            $request['id_empresa'] = $this->token['id_empresa'];
            $request['dt_nascimento'] = substr($request['dt_nascimento'], 0, 10);
            $request['img'] = $request['fileimg'];
            $request['nu_cpf_cnpj'] = Helpers::removerCaracteresEspeciaisEspacos($request['nu_cpf_cnpj']);
            $request['bo_ativo'] = true;
            $request['password']  = bcrypt($request['password']);

            if(!\App\Funcionario::verificarCpfExiste($request['nu_cpf_cnpj'],$this->token['id_empresa'])){
                return  response(["cpf"=>"Já possui funcionario com esse CPF"],200); 
            }
            $dadosBancarios = \App\DadosBancarios::create($request->all());
            if(!$dadosBancarios){
                return  response(["response"=>"Erro ao salvar Dados Bancarios"],200); 
            }

            $request['id_dados_bancarios'] = $dadosBancarios->id;
            $funcionario = \App\Funcionario::create($request->all());

            if(!$funcionario){
                return  response(["response"=>"Erro ao salvar Funcionario"],200); 
            }
            if(!\App\FuncionarioEmail::insertEmail($request['ds_email'],$funcionario->id)){
                return response(['response'=>'Erro ao inserir email'],200);
            }
            if(!\App\FuncionarioTelefone::insertTelefone($request['nu_telefone'],$funcionario->id)){
                return response(['response'=>'Erro ao inserir telefone'],200);
            }
            if(!\App\FuncionarioEndereco::insertEndereco($request['enderecos'],$funcionario->id)){
                return response(['response'=>'Erro ao inserir endereço'],200);
            }
            \DB::commit();
            return response(['response'=>'Funcionario inserido com sucesso']);
        }
        return response(["response"=>"Error",'dados'=>$funcionario]);
    
        
    }
    public function getBancos()
    {
        $bancos = \App\Bancos::select(\DB::raw("CONCAT(nu_banco,' - ',no_banco) as nu_no_banco"),'banco.*')->get();
        if(!$bancos){
            return response(["response"=>"Não existe bancos"],400);
        }
        return response(["bancos"=>$bancos],200);
    }
    public function getAniversariantePorMes()
    {
        $funcionarios = iterator_to_array(\App\Funcionario::getAniversariantePorMes($this->token['id_empresa']));
        $clientes = iterator_to_array(\App\ClienteFornecedor::getAniversariantePorMes($this->token['id_empresa']));
        if(!$funcionarios || !$clientes){
            // return response(["response"=>"Error em aniversariantes"],400);
        }
        $result = array_merge($funcionarios ,$clientes);
        return response(['result'=>$result],200);
    }
    public function getRelatoioComissao(Request $request)
    {
        $funcionarios = iterator_to_array(\App\Funcionario::getRelatorioComissao($request,$this->token['id_empresa']));
        // if(!$funcionarios){
        //     return response(["response"=>"Error em aniversariantes"],400);
        // }
        $funcionarios = \App\Funcionario::formatarRelatorio($funcionarios);
        $funcionarios = \App\Funcionario::formatarParaAngular($funcionarios);

        return response(['funcionarios'=>$funcionarios],200);
    }

    public function getTipoComissao()
    {
        $tipos = \App\TipoComissao::getTipoComissao();
        if(!$tipos){
            return response(["response"=>"Não existe Comissões"],400);
        }
        return response(["tipos"=>$tipos],200);
    }

    public function getGrupoPermissao()
    {
        $grupoPermissao = \App\GrupoPermissao::where('id_empresa',$this->token['id_empresa'])->get();
        if(!$grupoPermissao){
            return response(["response"=>"Não existe grupoPermissao"],400);
        }
        return response(["grupoPermissao"=>$grupoPermissao],200);
    }

    
    public function show($id)
    {
        $funcionario =\App\Funcionario::where('funcionario.id',$id)
        ->leftJoin('funcionario_email', 'funcionario_email.id_funcionario', '=', 'funcionario.id')
        ->leftJoin('email', 'funcionario_email.id_email', '=', 'email.id')
        ->leftJoin('funcionario_telefone', 'funcionario_telefone.id_funcionario', '=', 'funcionario.id')
        ->leftJoin('telefone', 'funcionario_telefone.id_telefone', '=', 'telefone.id')
        ->leftJoin('dados_bancarios', 'dados_bancarios.id', '=', 'funcionario.id_dados_bancarios')
        ->leftJoin('banco', 'dados_bancarios.id_banco', '=', 'banco.id')
        ->select('funcionario.*','dados_bancarios.nu_agencia','dados_bancarios.nu_conta_corrente','banco.no_banco','banco.no_site','banco.nu_banco','dados_bancarios.id_banco','email.ds_email','telefone.nu_telefone')->get()->first();

        if(!$funcionario){
            return response(["response"=>"Não existe funcionario"],400);
        }
        $endereco = \App\FuncionarioEndereco::getEnderecoByFuncionario($funcionario->id);
        
        return response(["dados"=>$funcionario,"enderecos"=>$endereco]);
        
    }

    
    public function update(Request $request, $id)
    {
        if ($request->hasFile('fileimg')) {
            if($img = Helpers::salveFile($request,'funcionario')){
                return response(["response"=>"imagem movida com sucesso",'file'=>$img['file']]);
            }   
        }else{
            \DB::beginTransaction();
            $request['nu_cpf_cnpj'] = Helpers::removerCaracteresEspeciaisEspacos($request['nu_cpf_cnpj']);
            if(strlen($request['dt_nascimento']) > 10){
                $request['dt_nascimento'] = substr($request['dt_nascimento'], 0, 10);
            }
         
            if(!\App\Funcionario::verificarCpfFuncionarioNotIn($request['nu_cpf_cnpj'],$id,$this->token['id_empresa'])){
                return  response(["cpf"=>"Já possui funcionario com esse CPF"],200); 
            }
            
            $funcionario = \App\Funcionario::find($id);
            $funcionario = Helpers::processarColunasUpdate($funcionario,$request->all());
            
            $funcionario->password  = \App\Funcionario::cripSenhaFuncionario($request['password'],$id);
            
            if(!$funcionario->update()){
                return  response(["response"=>"Erro ao alterar Funcionario"],200); 
            }
            unset($request['img']);
            $dadosBancarios = \App\DadosBancarios::find($funcionario->id_dados_bancarios);
            if($dadosBancarios){
                $dadosBancarios = Helpers::processarColunasUpdate($dadosBancarios,$request->all());

                if(!$dadosBancarios->update()){
                    return  response(["response"=>"Erro ao alterar Dados Bancarios"],200); 
                }
            }else{
                $dadosBancarios = \App\DadosBancarios::create($request->all());
                $funcionario->id_dados_bancarios = $dadosBancarios->id;
            }

            if(!\App\FuncionarioEmail::updateEmail($request['ds_email'],$funcionario->id)){
                return response(['response'=>'Erro ao inserir email'],200);
            }
            if(!\App\FuncionarioTelefone::updateTelefone($request['nu_telefone'],$funcionario->id)){
                return response(['response'=>'Erro ao inserir telefone'],200);
            }
            if(!\App\FuncionarioEndereco::updateEndereco($request['enderecos'],$funcionario->id)){
                return response(['response'=>'Erro ao inserir endereço'],200);
            }
            \DB::commit();
            return response(['response'=>'Funcionario Alterado com sucesso'],200);
        }
        return response(["response"=>"Error",'dados'=>$funcionario]);
      
    }
    

    public function destroy($id)
    {
        return ['destory'];
        $funcionario =  \App\Funcionario::find($id);
        if($funcionario['id'] != $this->token['id_empresa']){
            return response(['error'=>"Não tem permissão para alterar esse Funcionario"],400);
        }
        if(!$funcionario){
            return response(['response'=>'Funcionario Não encontrado'],400);
        }
        $funcionario->bo_ativo = false;
        if(!$funcionario->save()){
            return response(["response"=>"Erro ao deletar Funcionario"],400);
        }
        return response(['response'=>'Funcionario Inativado com sucesso']);
    }
}