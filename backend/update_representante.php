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
    $bd->start_transaction();


    if ($_POST['id'] == 0) {
        $dados['logo'] = "../dist/img/representantes/padrao.png";
        $bd->insert('representantes', $dados);
        $_POST['id'] = $bd->get("insert_id");
    }
    //UPDATE - representantes
    $table = 'representantes';
    $dados = $_POST;


    unset($dados['id']);

    foreach ($dados as $key => $value) {
        if ($key != 'linha') {
            $dados[$key] = "'" . $value . "'";
        }
    }

    $where = "codigo={$_POST['id']}";
    $bd->update($table, $dados, $where);

    $nome_input = "logo";

    if (!empty($_FILES[$nome_input]['name'])) {
        $target_dir = "../dist/img/representantes/";

        $file = $_FILES[$nome_input]["name"];
        $name = basename($file, pathinfo($file, PATHINFO_EXTENSION));
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        $date = new DateTime();
        $new_name = $name . "_" . $date->getTimestamp() . ".$extension";

        $target_file = $target_dir . $new_name;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Desculpe, esse arquivo já existe.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "jpe"
            && $imageFileType != "gif"
        ) {
            echo "Desculpe, somente arquivos JPG PNG JPEG e GIF são permitidos.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Desculpe, não foi possível subir seus arquivos.";
            exit;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$nome_input]["tmp_name"], $target_file)) {

                //INSERT - produto_midia (downloads)
                $table4 = "representantes";
                $dados4 = array("logo" => "'".$target_file."'");
                $where4 = "codigo={$_POST['id']}";
                $bd->update($table4, $dados4,$where4);


            } else {
                echo "Desculpe, ocorreu algum erro durante o uploading do seu arquivo.";
                exit;
            }
        }
    }
    $bd->record_log("log_login",'update_representante',$_POST['id']);
    $bd->commit();
    header('Location: ../pages/representantes.php');
}

