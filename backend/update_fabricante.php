<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 21/01/2016
 * Time: 10:47
 */

include_once "first_all.php";

if(isset($_POST) && $_POST !=""){


        $bd = new BD();
        $bd->start_transaction();

            $table = "fabricantes";

            if($_POST['id']==0){
                $dados['ativo'] = "true";
                $bd->insert($table,$dados);
                $_POST['id'] = $bd->get("insert_id");
            }

            $dados = $_POST;
            unset($dados['id']);
            $dados['nome'] =  "'".$dados['nome']."'";
            $where = "codigo={$_POST['id']}";
            $bd->update($table,$dados,$where);
            $bd->record_log("log_login",'update_fabricante',$_POST['id']);

        $bd->commit();
        header('Location: ../pages/geral.php');

}

