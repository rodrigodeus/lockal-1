<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 22/01/2016
 * Time: 09:53
 */

include_once "first_all.php";

$bd = new BD();



//OP zero para quando for alterar apenas o texto de um produto
if ( $_GET['tipo_op']==0) {

    $sql = "update produtos set cod_texto={$_GET['cod_texto']} where codigo={$_GET['cod_produto']}";



  ///  $bd->record_log("Detalhe de Produtos",'Alterou Descrição do produto',$_GET['cod_produto']);

}



//OP 1 para quando for alterar de uma família específica
if ( $_GET['tipo_op']==1) {

    $sql = "update produtos set cod_texto={$_GET['cod_texto']} where cod_familia={$_GET['cod_familia']}";


   /// $bd->record_log('Detalhe de Produtos','Alterou Descrição da familia',$_GET['cod_familia']);


}







$bd->query($sql);
$bd->getResult();



$sql = "select descricao from texto where id={$_GET['cod_texto']}";
$bd->query($sql);
echo $bd->getResult("json");





