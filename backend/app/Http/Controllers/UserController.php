<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
  
    public function show($id)
    {
        $usuario = \DB::table('usuario')->select('usuario', 'login','pessoa.*')
        ->join('pessoa', 'usuario.id_pessoa', '=', 'pessoa.id_pessoa')
        ->where('usuario.usuario', $id)
        ->get()
        ->first();
        if(!$usuario){
            return response(["response"=>"usuario não encontrado"],400);
        }
        return $usuario;
    }

}
