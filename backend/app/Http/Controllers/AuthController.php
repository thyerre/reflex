<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    private $jwtAuth; //tipo jwtAuth

    public function __construct (JWTAuth $jwtAuth){
        $this->jwtAuth = $jwtAuth;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');
        if (! $token = $this->jwtAuth->attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        $user = $this->jwtAuth->authenticate($token);
        // return response($user,401);
        $empresa = new \App\Empresa();
        $grupo = \App\PermissaoGrupo::where('id',$user->id_grupo_permissao)->first();
        $empresa = $empresa->getEmpresaById($user->id_empresa);
        
        return response()->json(compact('token','user','empresa','grupo'));
    }
    public function refresh(){
        $token = $this->jwtAuth->getToken();
        $token = $this->jwtAuth->refresh($token);
        return response()->json(compact('token'));
    }
    
    public function logout(){
        $token = $this->jwtAuth->getToken();
        $this->jwtAuth->invalidate($token);
        return response()->json(['logout'],202);
    }

    public function me(){
        if (! $user = $this->jwtAuth->parseToken()->authenticate()) {
            return response()->json(['error'=>'user_not_found'], 404);
        }
        return response()->json(compact('user'));
    }
}
