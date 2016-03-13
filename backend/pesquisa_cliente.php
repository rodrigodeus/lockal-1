<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 22/01/2016
 * Time: 09:53
 */

include_once "first_all.php";

$bd = new BD();

$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'clientes'";
$bd->query($sql);
$result = $bd->getResult('array');
$where = "";
if($result) {
    foreach ($result as $r) {
        $where .= $r['COLUMN_NAME'] . " like '%" . $_GET['p'] . "%' OR ";
    }
    $where = substr($where,0,-4);
}

$where_1 = ($_SESSION['admin']=='true')?"WHERE 1=1 AND (":" WHERE cod_parceiro={$_SESSION['codigo']} AND (";

$sql = "SELECT codigo,nome_razao,cpf_cnpj FROM clientes $where_1 $where )";
$bd->query($sql);
if($bd->getResult('json')){
    echo $bd->getResult('json');
}else{
    echo false;
};


