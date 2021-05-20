<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Usuario::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return \App\Usuario::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $usuario = \DB::table('usuario')->select('usuario', 'login','pessoa.*')
        // ->join('pessoa', 'usuario.id_pessoa', '=', 'pessoa.id_pessoa')
        // ->where('usuario.usuario', $id)
        // ->get()
        // ->first();
        // if(!$usuario){
        //     return response(["response"=>"usuario não encontrado"],400);
        // }
        // return $usuario;
        // return \App\Usuario::where('id_tipo_despesa','>', $id)->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipo =  \App\Usuario::findOrFail($id);

        $tipo->no_tipo_despesa = $request->no_tipo_despesa;
        if(!$tipo->save()){
            return response(["response"=>"Tipo não foi atualizado"],400);
        }
        return response(["response"=>"Atualizado com sucesso","id"=>$tipo->id_tipo_despesa]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return \App\Usuario::destroy($id);
        // ou 
        $tipo =  \App\Usuario::find($id);
        if(!$tipo){
            return response(['response'=>'Tipo Não encontrado'],400);
        }
        $tipo->delete();
        return response(['response'=>'Deletado com sucesso']);
    }
}
