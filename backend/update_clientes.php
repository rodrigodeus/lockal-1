<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 21/01/2016
 * Time: 10:47
 */

include_once "first_all.php";

print_r($_POST);

if(isset($_POST) && $_POST !=""){


        $bd = new BD();

            $table = "clientes";
            if($_POST['id']==0){
                $dados['ativo'] = "true";
                $bd->insert($table,$dados);
                $_POST['id'] = $bd->get("insert_id");
            }

            $dados = $_POST;
            unset($dados['id']);
            $where = "codigo={$_POST['id']}";
            $bd->update($table,$dados,$where);
            $bd->record_log("log_login",'update_clientes',$_POST['id']);

        header('Location: ../pages/clientes.php');
}
