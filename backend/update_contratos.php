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

        $table_1 = "fin_receber";
        $dados_1 = array(
            'valor'=>$_POST['me_total']/$_POST['me_parcelas'],
            'cod_contrato' => $_POST['id'],
            'ativo'=>'true'
        );

        $da = date('Y-m-d', strtotime($_POST['me_dia_vencimento']));
        $db = date('d', strtotime($da));

        for($i=1;$i<13;$i++){

            if($_POST['me_parcelas']<$i){
                $dados_1['ativo']='false';
                $dados_1['valor']= 0;
            }

            $dados_1['numero_parcela']=$i;

            $dm = date('m', strtotime($da));
            $dd = date('d', strtotime($da));

            if( $dm  == 2 && $dd >= 28 ){

                $d1 = date('Y-m-1', strtotime($da));
                $d2 = date('Y-m-d', strtotime("+1 month", strtotime($d1)));
                $r = date('Y-m-d', strtotime("-1 day", strtotime($d2)));
                $da = $d2;
                $da = date('Y-m-', strtotime($d2)).$db;

            }else{
                $r = date('Y-m-d', strtotime($da));
                if ($dm == 1 && $dd >= 28) {
                    $d1 = date('Y-m-1', strtotime($da));
                    $d2 = date('Y-m-d', strtotime("+2 month", strtotime($d1)));
                    $da = date('Y-m-d', strtotime("-1 day", strtotime($d2)));
                }else{
                    $da = date('Y-m-d', strtotime("+1 month", strtotime($da)));
                }
            }
            $dados_1['vencimento'] = $r;
            $bd->insert($table_1, $dados_1);

        }
    }

    //UPDATE - fin_receber
    foreach (array_keys($_POST) as $k) {
        if (preg_match('/^data_baixa_/', $k)) {
            echo $k;
            $table_2 = "fin_receber";
            $dados_2 = array("data_baixa"=>$_POST[$k],'usuario_baixou'=>$_SESSION['codigo']);
            $where_2 = "codigo =".str_replace("data_baixa_","",$k);
            $bd->update($table_2,$dados_2,$where_2);
        }
    }

    $dados = $_POST;
    unset($dados['id']);
    foreach (array_keys($_POST) as $k) {
        if (preg_match('/^data_baixa_/', $k)) {
            unset($dados[$k]);
        }
    }
    $where = "codigo={$_POST['id']}";
    $bd->update($table, $dados, $where);
    $bd->record_log("log_login", 'update_cadastro', $_POST['id']);

    header('Location: ../pages/detalhe_contrato.php?codigo=' . $_POST['id']);
}else{
    echo "Ops...algo saiu errado!";
}
