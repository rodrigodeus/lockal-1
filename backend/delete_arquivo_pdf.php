<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 19/01/2016
 * Time: 10:20
 */
include_once "first_all.php";
$bd= new BD();
$sql = "UPDATE produto_midia SET deletado='true' WHERE codigo=".$_GET['codigo'];
$bd->query($sql, true);
$bd->getResult();
$bd->record_log("log_login",'delete_arquivo_pdf',$_GET['codigo']);