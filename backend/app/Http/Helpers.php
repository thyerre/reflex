 
<?php
use Gregwar\Image\Image;
class Helpers{

    public static function convertdateBr2DB($date){
        if(empty($date)){
            return null;
        }
        $arDate = explode("/",$date);
        if(count($arDate) <= 1){
            return $date;
        }
        return date("$arDate[2]-$arDate[1]-$arDate[0]");
        return date('Y-m-d', strtotime(str_replace('-', '/', $date)));
        
    }

    public static function removerCaracteresEspeciaisEspacos($conteudo){
        return str_replace(array('(', ')', '[', ']', '{', '}', '-', ',', '.', '/', '\\', ';', ':', '?', '!', ' '), '', $conteudo);
    }
    
    public static function convertdateBr2DBTs($date){
        return date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)));
    }
    public static function removerVazio($controler,$request){
        foreach ($request as $key => $value) {
            if(!empty($value)){
                $tipo = substr($key, 0, 2); 
                $controler->$key = $value;
                if($tipo == 'dt'){
                    $controler->$key = Helpers::convertdateBr2DB($value);
                }
            }
        }
        return $controler;
    }

    public static function processar($controler,$request){
        foreach ($request as $key => $value) {
            $tipo = substr($key, 0, 2); 
            $controler->$key = (!empty($value))?$value:null;
            if($tipo == 'dt'){
                $controler->$key = Helpers::convertdateBr2DB($value);
            }
        }
        return $controler;
    }

    public static function processarColunas($colunas,$request){
        $ar =[];
        foreach ($request as $key => $value) {
            if(in_array($key,$colunas)){
                $tipo = substr($key, 0, 2); 
                $ar[$key] = (!empty($value))?$value:null;
                if($tipo == 'dt'){
                    $ar[$key] = Helpers::convertdateBr2DB($value);
                }
            }
        }
        return $ar;
    }

    public static function processarColunasUpdate($colunas,$request){
        $columns = $colunas->getFillable();
        
        foreach ($request as $key => $value) {
            $tipo = substr($key, 0, 2);
            if($tipo == 'dt'){
                $value = Helpers::convertdateBr2DB($value);
            }
            if(in_array($key,$columns)){
                $colunas->$key = $value;
            }else{
                if($key === "fileimg" && !is_null($value) && in_array("img",$columns)){
                    $colunas->img = $value; 
                }
                if($key === "fileimg_logo" && !is_null($value) && in_array("img_logo",$columns)){
                    $colunas->img_logo = $value; 
                }
            }
        }
        return $colunas;
    }

    public static function saveFileGeneric($file, $folder){
        
            $doc = $file;
            //Recupera o nome original do arquivo
            $filename  = $doc->getClientOriginalName();
            
            //Recupera a extensão do arquivo
            $extension = $doc->getClientOriginalExtension();
            //Definindo um nome unico para o arquivo
            $name  = date('His_Ymd').'_'.str_replace(' ','',$filename);
            
            //Diretório onde será salvo os arquivos
            $destinationPath = 'img/'.$folder;
            if($folder == "empresa" && $extension == "png"){
                $pathName = $doc->getPathName();
                // $nome = date('d-m-Y-H-i-s');
                // $file = $request->hasFile('fileimg');
                // $sa = $request;
                $InfoImagem = getimagesize($pathName);
                $nameJpg = str_replace('.png','.jpg',$name);
                Image::open($pathName)
                ->resize($InfoImagem[0], $InfoImagem[1])
                ->save($destinationPath."/".$nameJpg, 'jpg');
            }
            //Move o arquivo para a pasta indicada
            if($doc->move($destinationPath, $name)){
                return ['file'=>$name];
                
            }
            
        
        return false;
    }
    
    public static function salveFile($request,$folder){
        if ($request->hasFile('fileimg')) {
            $doc = $request->file('fileimg');

                //Recupera o nome original do arquivo
                $filename  = $doc->getClientOriginalName();

                //Recupera a extensão do arquivo
                $extension = $doc->getClientOriginalExtension();

                //Definindo um nome unico para o arquivo
                $name  = date('His_Ymd').'_'.str_replace(' ','',$filename);

                //Diretório onde será salvo os arquivos
                $destinationPath = 'img/'.$folder;
                //Move o arquivo para a pasta indicada
                if($doc->move($destinationPath, $name)){
                    return ['file'=>$name];
                    
                }
        }
        return false;
        
    }
    public static function baixarSalveFile($link,$folder){
        if ($link) {
            $url = $link;

            $ch = curl_init($url);
            $nameImg = date('His_Ymd').'_'.str_replace(' ','',$folder).".".pathinfo($url)['extension'];
            $fp = fopen("img/{$folder}/{$nameImg}", 'wb');

            try {
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
            }
            catch(Exception $e){
                return false;
                throw new Exception("Invalid URL",0,$e);
            }
            // $doc = $request->file('fileimg');

            //     //Recupera o nome original do arquivo
            //     $filename  = $doc->getClientOriginalName();

            //     //Recupera a extensão do arquivo
            //     $extension = $doc->getClientOriginalExtension();

                //Definindo um nome unico para o arquivo
                // $name  = date('His_Ymd').'_'.str_replace(' ','w',$filename);

                //Diretório onde será salvo os arquivos
                // $destinationPath = 'img/'.$folder;
                //Move o arquivo para a pasta indicada
                // if($doc->move($destinationPath, $name)){
                //     return ['file'=>$name];
                    
                // }
            return ['file'=>$nameImg];
        }
        return false;
        
    }

    public static function verificarArquivoCertificado($certificado){
        $status = true;
        if(!$certificado){
            $status = false;
        }else{
            if(!file_exists('img/empresa/'.$certificado->file_certificado)){
                $status = false;
            }
        }
        return $status;
    }
    public static function searchWhere($query,$model,$search,$arWhereAnothersTables = null){
        if(!empty($search)){
            $path = explode('\\', $model);
            $model = array_pop($path);
            $model = str_replace("Controller", "", $model);
            $class = '\App\\' . $model;
            $m = new $class;
            $fillable = $m->getFillable();

            $query->where(function($query) use ($search,$fillable,$m,$arWhereAnothersTables){
                if($arWhereAnothersTables){
                    foreach ($arWhereAnothersTables as $value) {
                        $query->orWhere($value, 'LIKE', '%' . $search . '%');
                    }
                }
                foreach ($fillable as $column) {
                    $query->orWhere($m->getTable().".".$column, 'LIKE', '%' . $search . '%');
                }
            });
        }
        return $query;
    }
    public function getOSClient() { 
        $user_agent =$_SERVER['HTTP_USER_AGENT'];
        $os_platform  = "Unknown OS Platform";
        $os_array = array(
            '/windows/i'    => 'Windows',
            '/linux/i'      => 'Linux',
            '/iphone/i'     => 'iPhone',
            '/ipod/i'       => 'iPod',
            '/ipad/i'       => 'iPad',
            '/android/i'    => 'Android',
        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }
    function formatCnpjCpf($value)
    {
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } 

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }
    function formatarDataTS($data){
        return date("d/m/Y H:i", strtotime($data));
    }
    function formatarData($data){
        return date("d/m/Y", strtotime($data));
    }
    public static function  formatarDataParaBanco($data){
        $arData = explode('/',$data);
        return $arData[2]."-".$arData[1]."-".$arData[0];
    }
    public static function  validarExt($ext,$arExt){
        if(in_array($ext,$arExt)){
            return true;
        }
        return false;
    }
    public static function count($arrayOrContable)
    {
        if (is_countable($arrayOrContable) || is_array($arrayOrContable) || $arrayOrContable instanceof \Countable) {
            return count($arrayOrContable);
        }

        return null === $arrayOrContable ? 0 : 1;
    }
}
