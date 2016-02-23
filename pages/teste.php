<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 18/01/2016
 * Time: 12:10
 */
include "../backend/conn.php";

$v = file_get_contents("http://fipeapi.appspot.com/api/1/carros/marcas.json");
$v = json_decode($v);
foreach($v as $k){
    echo "<pre>";
    print_r($k);
    echo "</pre>";
    $sql = "INSERT INTO marcas (codigo,name) VALUES (".$k->id.",'".$k->fipe_name."')";
    $bd = new BD();
    $dados['codigo'] = $k->id;
    $dados['nome'] = $k->fipe_name;
    $table = "marcas";
    $bd->insert($table,$dados);
}

