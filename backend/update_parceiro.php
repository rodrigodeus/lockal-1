<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 21/01/2016
 * Time: 10:47
 */

include_once "first_all.php";


if(isset($_POST) && $_POST !=""){

        //print_r($_POST);
        $bd = new BD();

            $table = "parceiros";
            if($_POST['id']==0){
                $dados['ativo'] = "true";
                $bd->insert($table,$dados);
                $_POST['id'] = $bd->get("insert_id");
            }

            $dados = $_POST;
            $dados['admin'] = (isset($_POST['admin']))?'true':'false';
            unset($dados['id']);
            $where = "codigo={$_POST['id']}";
            $bd->update($table,$dados,$where);
            $bd->record_log("log_login",'update_parceiros',$_POST['id']);

        header('Location: ../pages/parceiros.php');
}

