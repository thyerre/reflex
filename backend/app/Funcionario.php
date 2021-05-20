<?php

namespace App;
use Helpers;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = "funcionario";
    protected $primaryKey   = "id";
    protected $fillable = ['no_funcionario','bo_fisico','no_pai','no_mae','dt_nascimento','bo_ativo','cargo_funcionario','id_dados_bancarios','vl_salario','porcentagem_comissao','tp_comissao','ds_observacao','nu_cpf_cnpj','id_grupo_permissao','created_at','updated_at','id_empresa','img','login','password']; 
    
    // protected $hidden = [
    //     'password',
    // ];
  
    public static function verificarCpfExiste($cpf,$id_empresa){
        $funcionario = \App\Funcionario::where('id_empresa',$id_empresa)->where('nu_cpf_cnpj',$cpf)->get()->first();
        if($funcionario){
            \DB::rollBack();
            return false;
        }
        return true;
    }
    public static function verificarCpfFuncionarioNotIn($cpf,$id_funcionario,$id_empresa){
        $funcionario = \App\Funcionario::where('id_empresa',$id_empresa)->where('nu_cpf_cnpj',$cpf)->get();
        if(!empty($funcionario)){
            if(Helpers::count($funcionario) > 1 || $funcionario[0]->id != $id_funcionario){
                \DB::rollBack();
                return false;
            }
        }
        return true;
    }
    public static function getAniversariantePorMes($id_empresa){
        $funcionario = \App\Funcionario::where('id_empresa',$id_empresa)
        ->select(\DB::raw("DATE_FORMAT(funcionario.dt_nascimento,'%d') as data"),\DB::raw('funcionario.no_funcionario as nome'),'funcionario.img',\DB::raw("'fun' as tipo"))
        ->whereRaw('month(dt_nascimento) = '.date('m'))
        ->whereRaw('day(dt_nascimento) >= '.date('d'))->get();
        return $funcionario;
    }
    public static function getRelatorioComissao($request,$id_empresa){
        $query = \App\Funcionario::query();
        $query = $query->where('funcionario.id_empresa',$id_empresa)
        ->where('produto.id_empresa',$id_empresa)
        ->where('venda.id_empresa',$id_empresa)
        ->join("venda",'venda.id_funcionario', '=', 'funcionario.id') 
        ->join("venda_item",'venda_item.id_venda', '=', 'venda.id') 
        ->join("produto",'produto.id', '=', 'venda_item.id_produto') 
        ->join("cliente_fornecedor",'cliente_fornecedor.id', '=', 'venda.id_cliente_fornecedor') 
        ->where('produto.bo_ativo',true)
        ->where('funcionario.bo_ativo',true)
        ->where('venda.bo_ativo',true)
        ->where('produto.bo_comissao',true)
        ->where('venda.bo_orcamento',false)
        ->where('funcionario.tp_comissao','cv')
        ->select(\DB::raw("funcionario.porcentagem_comissao,funcionario.id as id_funcionario,venda.id as id_venda,funcionario.no_funcionario,venda.dt_venda,venda_item.vl_venda_total,venda_item.id_produto,produto.no_produto"),\DB::raw("CONCAT(COALESCE(cliente_fornecedor.no_pessoa,''),COALESCE(cliente_fornecedor.no_razao_social,'')) AS no_cliente"));
        $query = self::setWhere($request,$query);
        return $query->get();
    }
    public static function  setWhere($arwhare, $query){
       
        $existWhere = false; 
        if($arwhare->dt_inicial){
            $query->where('venda.dt_venda','>=',$arwhare->dt_inicial.' 00:00:00');
            $existWhere = true; 
        }
        if($arwhare->dt_final){
            $query->where('venda.dt_venda','<=',$arwhare->dt_final.' 23:59:59');
            $existWhere = true; 
        }
        if($arwhare->id_funcionario){
            $query->where('funcionario.id',$arwhare->id_funcionario);
            $existWhere = true; 
        }
        if(!$existWhere){
            $data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
            $data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
            
            $query->where('venda.dt_venda','>', date('Y-m-d',$data_incio).' 00:00:01');
            $query->where('venda.dt_venda','<', date('Y-m-d',$data_fim).' 59:23:59');
        }
        return $query;
    }
    public static function cripSenhaFuncionario($newSenha,$id){
        if(!$newSenha){
            $funcionario = \App\Funcionario::find($id);
            return $funcionario->password;
        }else{
            return bcrypt($newSenha);

        }
    }
    public static function formatarRelatorio($arRelatorio){
        $ar = array();
        foreach ($arRelatorio as $key => $value) {
            $ar[$value['id_funcionario']]['no_funcionario'] = $value['no_funcionario'];
            $ar[$value['id_funcionario']][$value['id_venda']] = $value;
            // $ar[$value['id_funcionario']][$value['id_venda']]['venda_total'] += $value['vl_venda_total'];
        }
        return $ar;
    }
    public static function formatarParaAngular($arRelatorio){
        $ar = array();
        $i = 0;
        $j = 0;
        foreach ($arRelatorio as $key => $value) {
            $ar[$i]['no_funcionario'] = $value['no_funcionario'];
            unset($value['no_funcionario']);
            $j = 0;
            $por = 0;
            $total = 0;
            foreach ($value as $k => $v) {
                $total += $v['vl_venda_total'];
                $por = $v['porcentagem_comissao'];
                $ar[$i]['vendas'][$j++] = $v;
            }
            $ar[$i]['porcentagem_comissao'] = $por;
            $ar[$i]['venda_total'] = $total;
            $i++;
        }
        return $ar;
    }
    
} 
