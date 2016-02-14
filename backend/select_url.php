<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 18/01/2016
 * Time: 11:08
 */

include_once "first_all.php";

$bd = new BD();

$sql = "SELECT url FROM produto_midia WHERE tipo='video' AND cod_produto=".$_GET['codigo'];
$bd->query($sql);
$rs = $bd->getResult();
if (mysql_num_rows($rs) > 0) {
    $out = array();
    while ($row = mysql_fetch_assoc($rs)) {
        extract($row);
        $out[] = $url;
    };
    echo json_encode($out);
};