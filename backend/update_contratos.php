<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 21/01/2016
 * Time: 10:47
 */

include_once "first_all.php";


if (isset($_POST) && $_POST != "") {

    $bd = new BD();

    $table = "contratos";
    if ($_POST['id'] == 0) {
        $dados['ativo'] = "true";
        $bd->insert($table, $dados);
        $_POST['id'] = $bd->get("insert_id");
    }

    $dados = $_POST;
    unset($dados['id']);
    $where = "codigo={$_POST['id']}";
    $bd->update($table, $dados, $where);
    $bd->record_log("log_login", 'update_cadastro', $_POST['id']);

    if (isset($_GET['r'])) {
        header('Location: ../pages/detalhe_contrato.php?codigo=' . $_POST['id']);
    } else {
        header('Location: ../pages/contratos.php');
    }
}
