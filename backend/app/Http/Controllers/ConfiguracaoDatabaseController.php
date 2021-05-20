<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use JWTAuth;

class ConfiguracaoDatabaseController extends Controller
{
    private $token;

    public function __construct() 
    {
        $this->token = JWTAuth::parseToken()->authenticate();
    }
    
    public function index()
    {
        $configuracaoDatabase = \App\ConfiguracaoDatabase::all()->first();
        return response($configuracaoDatabase);
    }

    
    public function store(Request $request){}

    
    public function show($type){
        $configuracaoDatabase = \App\ConfiguracaoDatabase::where("type",$type)->first();
        return response($configuracaoDatabase);
    }

    
    public function update(Request $request, $id)
    {
        $configuracaoDatabase =  \App\ConfiguracaoDatabase::find($id);
       
        if(!$configuracaoDatabase){
            return response(['response'=>'configuracao Database Não encontrado'],400);
        }
        $configuracaoDatabase = Helpers::processarColunasUpdate($configuracaoDatabase,$request->all());
        
        if(!$configuracaoDatabase->update()){
            return response(['response'=>'Erro ao alterar'],400);
        }
        return response(['response'=>'Atualizado com sucesso']);
      
    }
    

    public function destroy($id){}
}