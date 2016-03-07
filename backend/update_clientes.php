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

            $table = "clientes";
            print_r($_SESSION);
            if($_POST['id']==0){
                $dados['ativo'] = "true";
                $dados['cod_parceiro'] = $_SESSION['codigo'];
                $bd->insert($table,$dados);
                $_POST['id'] = $bd->get("insert_id");
            }

            $dados = $_POST;
            unset($dados['id']);
            $where = "codigo={$_POST['id']}";
            $bd->update($table,$dados,$where);
            $bd->record_log("log_login",'update_clientes',$_POST['id']);

        if(isset($_GET['r'])){
            header('Location: ../pages/detalhe_contrato.php?codigo=0');
        }else{
            header('Location: ../pages/clientes.php');
        }

}
