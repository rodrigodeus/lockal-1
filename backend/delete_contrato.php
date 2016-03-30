<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 22/01/2016
 * Time: 16:57
 */

include_once "first_all.php";

$bd = new BD();
    //print_r($_GET);
    $table = "contratos";
    $dados['ativo'] =  "false";
    $dados['obs_cancelamento'] =  $_GET['obs_cancelamento'];
    $where = "codigo=".$_GET['codigo'];
    $bd->update($table,$dados,$where);
    $bd->record_log("log_login",'delete_contrato',$_GET['codigo']);

header('Location: ../pages/contratos.php');