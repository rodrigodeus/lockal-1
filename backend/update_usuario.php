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

            $table = "usuarios";

            if($_POST['id']==0){
                $dados['ativo'] = "true";
                $bd->insert($table,$dados);
                $_POST['id'] = $bd->get("insert_id");
            }

            $dados = $_POST;
            unset($dados['id']);
            $dados['admin'] = ( $dados['admin'] == 'on')?'true':'false';
            foreach ($dados as $key=>$campo){
                $dados[$key] = "'".$campo."'";
            }
            $where = "codigo={$_POST['id']}";
            $bd->update($table,$dados,$where);

            $bd->record_log("log_login",'update_usuarios',$_POST['id']);

        $bd->commit();
        header('Location: ../pages/usuarios.php');

}

