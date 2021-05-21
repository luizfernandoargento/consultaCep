<?php
session_start();
// $_SESSION['lista'] = null;

$lista;

if(isset($_SESSION['lista'])){
    $lista = (array)$_SESSION['lista'];
}

function xmlToArray(SimpleXMLElement $xml){
    $array = array();
    foreach ($xml as $item => $valor) {
        ($node = & $array[$item])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = & $node[];

        $node = $valor->count() ? xmlToArray($valor) : trim($valor);
    }
    return $array;
}

function emCache($cep){
    global $lista;
    
    if(isset($lista) && array_key_exists($cep, $lista)){
        return $lista[$cep];
    }
    return false;
}

function armazenaCep($array){
    global $lista;
    
    $cep = $array['cep'];
    //print_r("<script>alert($lista);</script>");

    if(!isset($lista)){
        $lista = [$cep=>$array];
    } else {
        $lista += [$cep=>$array];
    }
    
    $_SESSION['lista'] = $lista;
    // print_r($lista);
}

function montaResultado($array){
    
    $conteudo = '<h5 class="list-group-item list-group-item-info"><b>Resultado da Pesquisa</b></h5>';
    if($array){
        $conteudo .= '<p> <ul class="list-group">';
        $conteudo .= '<li class="list-group-item"><b>CEP: </b>'.$array["cep"].'</li><br>';
        $conteudo .= '<li class="list-group-item"><b>Logradouro: </b>'.$array["logradouro"].'</li><br>';
        $conteudo .= '<li class="list-group-item"><b>Bairro: </b>'.$array["bairro"].'</li><br>';
        $conteudo .= '<li class="list-group-item"><b>Cidade: </b>'.$array["localidade"].'</li><br>';
        $conteudo .= '<li class="list-group-item"><b>Estado: </b>'.$array["uf"].'</li></ul><br> </p>';
    } else {
        $conteudo .= '<h6 class="list-group-item list-group-item-danger"">Endereço não encontrado.</h6> </p>';
    }
    return $conteudo;
}

function alerta(){
    echo '<script>'
    .'var elem = document.getElementById("cep");'
    .'elem.focus();'
    .'</script>';
}
    
function getEndereco(){
    global $lista;
    if(isset($_POST['cep'])){
        // $cep = preg_replace("/[^0-9]/", "", $_POST['cep']);
        // $cep = preg_replace("/(\d{5})/", "\$1-\$2", $cep);
        $cep = $_POST['cep'];
        if(strlen($cep) == 9){
            $emCache = emCache($cep);

            if($emCache) {
                // echo '<script>alert("Em cache");</script>';
                return montaResultado($emCache);
            } else {
                // echo '<script>alert("Pesquisando");</script>';
                $url = "http://viacep.com.br/ws/$cep/xml/";
                $xml = simplexml_load_file($url);
                
                $array = xmlToArray($xml);
                if(!array_key_exists('erro', $array)) {
                    armazenaCep($array);
                    return montaResultado($array);
                } else {
                    return montaResultado(false);
                }
            }
        } else {
            alerta();
            return montaResultado(false);
        }
    }
}
?>