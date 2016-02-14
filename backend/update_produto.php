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

        if($_POST['id']==0){
            $dados['status'] = "Ativo";
            $bd->insert('produtos',$dados);
            $_POST['id'] = $bd->get("insert_id");
        }

        //UPDATE - produtos
        $table = 'produtos';
        $dados = array("nome_produto" => "'".$_POST['nome_produto']."'",
                        "detalhamento" => "'".$_POST['detalhamento']."'",
                        "cod_linha"=>$_POST['linha'],
                        "status"=>"'".$_POST['status']."'",
                        "url"=>"'".$_POST['url']."'",
                        "fios"=>$_POST['fios'],
                        "desconto"=>"'".$_POST['desconto']."'",
                        "substituido"=>$_POST['substituido_por']);
        $where = "codigo={$_POST['id']}";
        $bd->update($table, $dados,$where);

        //DELETE - produto_aplicacao
        $table1 = "produto_aplicacao";
        $where1 = "cod_produto={$_POST['id']}";
        $bd->delete($table1,$where1);

        //INSERT - produto_aplicacao
        foreach (array_keys($_POST) as $k) {
            if (preg_match('/^aplicacao_/', $k)) {
                $dados2 = array("cod_produto"=>$_POST['id'],"cod_aplicacao"=>$_POST[$k]);
                $bd->insert($table1,$dados2);
            }
        }

        //DELETE - produto_veiculo
        $table2 = "produto_veiculo";
        $str="";

        foreach (array_keys($_POST) as $k) {
            if (preg_match('/^veiculo_registrado_/', $k)) {
                $str .= " AND codigo<>{$_POST[$k]}";
            }
        }
        $where2 = "cod_produto={$_POST['id']} $str";
        $bd->delete($table2,$where2);


        //INSERT - produto_veiculo
        foreach (array_keys($_POST) as $k) {
            if (preg_match('/^veiculo_novo_/', $k)) {
                $json = json_decode(htmlspecialchars_decode($_POST[$k]));
                $json->cod_produto = $_POST['id'];

                if($json->cod_veiculo == 0){
                    $sql = "SELECT codigo FROM veiculos WHERE cod_fabricante={$json->cod_fabricante}";
                    $bd->query($sql);
                    $a = ($bd->getResult('array'));
                    for($i=0;$i<count($a);$i++){
                        $json = (array)$json;
                        $json['cod_veiculo'] = $a[$i]['codigo'];
                        $bd->insert($table2,$json);
                    }
                }else{
                    $json = (array)$json;
                    $bd->insert($table2,$json);
                }

            }
        }


        //UPDATE - produto_midia (videos)
        $table3 = "produto_midia";
        $dados3 = array("deletado" => 'true');
        $where3 = "cod_produto={$_POST['id']} AND tipo='video' AND deletado='false'";
        $bd->update($table3, $dados3,$where3);


        //INSERT - produto_midia (videos)
        foreach (array_keys($_POST) as $k) {
            if (preg_match('/^video_/', $k)) {
                $dados3 = array("cod_produto"=>$_POST['id'],"tipo"=>'video',"url"=>$_POST[$k]);
                $bd->insert($table3,$dados3);
            }
        }

        if(!empty($_FILES['arquivo_pdf']['name'][0])) {
            for ($i = 0; $i < count($_FILES["arquivo_pdf"]["name"]); $i++) {
                $target_dir = "../../downloads/";

                $file = $_FILES["arquivo_pdf"]["name"][$i];
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
                if ($imageFileType != "pdf") {
                    echo "Desculpe, somente arquivos PDF são permitidos.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Desculpe, não foi possível subir seus arquivos.";
                    exit;
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["arquivo_pdf"]["tmp_name"][$i], $target_file)) {

                        //INSERT - produto_midia (downloads)
                        $table4 = "produto_midia";
                        $dados4 = array("cod_produto" => $_POST['id'], "tipo" => 'download', "url" => $target_file, "titulo" => $name);
                        $bd->insert($table4, $dados4);


                    } else {
                        echo "Desculpe, ocorreu algum erro durante o uploading do seu arquivo.";
                        exit;
                    }
                }
            }
        }
        $bd->record_log("log_login",'update_produto',$_POST['id']);
        $bd->commit();
        header('Location: ../pages/detalhe_produto.php?codigo='.$_POST['id']);

}

