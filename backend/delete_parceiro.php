<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 22/01/2016
 * Time: 16:57
 */

include_once "first_all.php";

$bd = new BD();

    $table = "parceiros";
    $dados['ativo'] =  "false";
    $where = "codigo=".$_GET['codigo'];
    $bd->update($table,$dados,$where);
    $bd->record_log("log_login",'delete_parceiro',$_GET['codigo']);

header('Location: ../pages/parceiros.php');