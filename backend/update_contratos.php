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
    $table_1 = "fin_receber";

    if ($_POST['id'] == 0) {
        $dados['ativo'] = "true";
        $bd->insert($table, $dados);
        $_POST['id'] = $bd->get("insert_id");

        $da = date('Y-m-d', strtotime($_POST['me_dia_vencimento']));
        $db = date('d', strtotime($da));
        for ($i = 1; $i < 13; $i++) {



            $dados_1['ativo'] = 'true';
            $dados_1['numero_parcela'] = $i;
            $dados_1['valor'] = ($_POST['me_total'] / $_POST['me_parcelas']);

            if ($_POST['me_parcelas'] < $i) {
                $dados_1['valor'] = 0;
                //$dados_1['numero_parcela'] = 0;
            }

            $dm = date('m', strtotime($da));
            $dd = date('d', strtotime($da));

            if ($dm == 2 && $dd >= 28) {

                $d1 = date('Y-m-1', strtotime($da));
                $d2 = date('Y-m-d', strtotime("+1 month", strtotime($d1)));
                $r = date('Y-m-d', strtotime("-1 day", strtotime($d2)));
                $da = $d2;
                $da = date('Y-m-', strtotime($d2)) . $db;

            }else{
                $r = date('Y-m-d', strtotime($da));
                if ($dm == 1 && $dd >= 28) {
                    $d1 = date('Y-m-1', strtotime($da));
                    $d2 = date('Y-m-d', strtotime("+2 month", strtotime($d1)));
                    $da = date('Y-m-d', strtotime("-1 day", strtotime($d2)));
                } else {
                    $da = date('Y-m-d', strtotime("+1 month", strtotime($da)));
                }
            }
            $dados_1['vencimento'] = $r;
            $dados_1['cod_contrato'] = $_POST['id'];
            $bd->insert($table_1, $dados_1);
        }
    }


        //UPDATE - fin_receber
        foreach (array_keys($_POST) as $k) {
            if (preg_match('/^data_baixa_/', $k)) {
                $dados_2 = array("data_baixa" => $_POST[$k], 'usuario_baixou' => $_SESSION['codigo']);
                $where_2 = "codigo =" . str_replace("data_baixa_", "", $k);
                $bd->update($table_1, $dados_2, $where_2);
            }
            if (preg_match('/^data_vencimento_/', $k)) {
                $dados_2 = array("vencimento" => $_POST[$k]);
                $where_2 = " codigo =" . str_replace("data_vencimento_", "", $k);
                $bd->update($table_1, $dados_2, $where_2);
            }
            if (preg_match('/^data_descricao_/', $k)) {
                $dados_2 = array("descricao" => $_POST[$k]);
                $where_2 = "codigo =" . str_replace("data_descricao_", "", $k);
                $bd->update($table_1, $dados_2, $where_2);
            }
            if (preg_match('/^data_valor_/', $k)) {
                $_POST[$k] = str_replace(".", "", $_POST[$k]);
                $_POST[$k] = str_replace(",", ".", $_POST[$k]);
                $dados_2 = array("valor" => $_POST[$k]);
                $where_2 = "codigo =" . str_replace("data_valor_", "", $k);
                $bd->update($table_1, $dados_2, $where_2);
            }
        }
        $dados = $_POST;

        unset($dados['id']);

        foreach (array_keys($_POST) as $k) {
            if (preg_match('/^data_baixa_/', $k)) {
                unset($dados[$k]);
            }
            if (preg_match('/^data_vencimento_/', $k)) {
                unset($dados[$k]);
            }
            if (preg_match('/^data_descricao_/', $k)) {
                unset($dados[$k]);
            }
            if (preg_match('/^data_valor_/', $k)) {
                unset($dados[$k]);
            }
        }
        $where = "codigo={$_POST['id']}";
        $bd->update($table, $dados, $where);
        $bd->record_log("log_login", 'update_cadastro', $_POST['id']);

    header('Location: ../pages/detalhe_contrato.php?codigo=' . $_POST['id']);
} else {
    echo "Ops...algo saiu errado!";
}
