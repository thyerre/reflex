<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $token;

    public function __construct() 
    {
        $this->token = JWTAuth::parseToken()->authenticate();
    }
    public function index()
    {
        $funcionario = \App\Funcionario::join("grupo_permissao as gp", 'gp.id', '=', 'funcionario.id_grupo_permissao')
            ->where('funcionario.id', $this->token['id'])
            ->get()->first();
        $superUser = ['admin', 'superadmin', 'administirador'];
        if (in_array(strtolower($funcionario->no_grupo_permissao), $superUser)) {
            $menu = \App\Menu::Join('tb_sistema_rotina', 'tb_sistema_modulo.cd_sistema_modulo', '=', 'tb_sistema_rotina.cd_sistema_modulo')
            ->select('tb_sistema_rotina.*','tb_sistema_modulo.*')
            ->where('tb_sistema_modulo.bo_ativo',1)
            ->where('tb_sistema_rotina.bo_ativo',1)
            ->where('tb_sistema_rotina.bo_mostrar_menu',1)
            ->orderBy('nu_ordem')
            ->get();
        }else{   
            $menu = \App\Funcionario::Join('grupo_permissao_rotina as gpr', 'gpr.id_grupo_permissao','=','funcionario.id_grupo_permissao')
            ->Join('tb_sistema_rotina as r', 'r.cd_sistema_rotina','=','gpr.id_rotina')
            ->select('r.*','gpr.bo_read')
            ->where('r.bo_ativo',1)
            ->where('r.bo_mostrar_menu',1)
            ->where('funcionario.id',$this->token['id'])
            ->where('gpr.bo_read',1)
            ->orderBy('nu_ordem')
            ->get();
        }
        
        
        // return $menu;
        return $this->buildTree($menu->toArray());
    }
    public function getMenus(){
        
    }
   
    public function processarMenu($ar){
        $array = array();
        $cont = 0;
        foreach($ar as $key => $value){
            $array[$value['no_modulo'].'_'.$value['cd_sistema_modulo']][] = array(
                'cd_sistema_rotina'=>$value['cd_sistema_rotina'],
                'ds_rotina'=>$value['ds_rotina'],
                'no_rotina'=>$value['no_rotina'],
                'icone'=>$value['icone'],
                'ds_url'=>$value['ds_url']
            );
           $cont++;
        }
        
        return json_decode(json_encode($array), true);
    }
    function buildTree($items) {

        $childs = array();
    
        foreach($items as $item)
            $childs[$item['cd_sistema_modulo']][] = $item;
    
        foreach($items as $item) if (isset($childs[$item['cd_sistema_rotina']]))
            $item['childs'] = $childs[$item['cd_sistema_rotina']];
    
        return (array)$childs;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
