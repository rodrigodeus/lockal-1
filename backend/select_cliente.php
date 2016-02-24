<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 22/01/2016
 * Time: 09:53
 */

require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT a.*,a.codigo cod_cliente, b.apelido_fantasia nome_parceiro, b.codigo cod_parceiro FROM clientes a left join parceiros b on b.codigo=a.cod_parceiro WHERE a.codigo=" . $_GET['codigo'];
$bd->query($sql);
echo $bd->getResult("json");
