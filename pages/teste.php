<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 18/01/2016
 * Time: 12:10
 */
include_once "../backend/first_all.php";

$bd = new BD();
$sql = "SELECT a.* FROM produtos a JOIN geral b ON b.cod=a.codigo WHERE MATCH (a.nome_produto,b.nome, a.detalhamento) AGAINST ('\"ford vidros\"+\"ford\"+\"vidros\"' IN BOOLEAN MODE) group by b.cod";
header('Location: ../index.php');
