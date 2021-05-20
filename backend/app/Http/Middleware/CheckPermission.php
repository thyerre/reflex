<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private function in_multiarray($elem, $array)
    {
        while (current($array) !== false) {
            if (current($array) == $elem) {
                return true;
            } elseif (is_array(current($array))) {
                if (self::in_multiarray($elem, current($array))) {
                    return true;
                }
            }
            next($array);
        }
        return false;
    }
    public function handle($request, Closure $next, $id_rotina)
    {
        $headerFrontend = $request->header('referer');
        $pathArrayFrontend = explode("/", $headerFrontend);
        $path = $request->path();
        $pathArray = explode("/", $path);
        $id = (int) end($pathArray);

        $method = $request->method();
        $token = JWTAuth::parseToken()->authenticate();
        $user = \App\GrupoPermissaoRotina::getPermissaoUser($token);
        // $permissoes = \App\GrupoPermissaoRotina::getPermissoesByGrupo($user->id_grupo_permissao);
        $permissoes = \App\GrupoPermissaoRotina::where('id_grupo_permissao', $user->id_grupo_permissao)->get();
        $permission = false;
        foreach ($permissoes as $key => $value) {
            if ($value->id_rotina == $id_rotina) {
                switch ($method) {
                    case 'GET':
                        if ($id > 0) {
                            if (in_array('detalhar', $pathArrayFrontend)) {
                                if ($value->bo_show) {
                                    return $next($request);
                                }
                            } else if (in_array('alterar', $pathArrayFrontend)) {
                                if ($value->bo_update) {
                                    return $next($request);
                                }
                            } else if (in_array('pdv', $pathArrayFrontend)) {
                                if ($value->bo_create) {
                                    return $next($request);
                                }
                            }
                        } else {
                            if ($value->bo_read) {
                                return $next($request);
                            }
                        }
                        break;

                    case 'POST':
                        if ($value->bo_create) {
                            return $next($request);
                        }
                        break;
                    case 'PUT':
                        if ($value->bo_update) {
                            return $next($request);
                        }
                        break;
                    case "DELETE":
                        if ($value->bo_delete) {
                            return $next($request);
                        }
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }
        return response(["response" => "Sem Permissão ($path)", "permission" => false], 401);
    }
}
