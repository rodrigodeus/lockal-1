<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 22/01/2016
 * Time: 09:53
 */

include_once "first_all.php";

$bd = new BD();

$sql = "SELECT codigo,nome FROM veiculos WHERE cod_fabricante={$_GET['cod_fabricante']}";
echo $bd->SetComboSelect($sql,'cod_veiculo','','form-control');