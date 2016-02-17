<?php require_once "../backend/first_all.php";

$bd = new BD();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php
include_once "head.php";
?>

<body>

<div id="wrapper">

    <?php
    include_once "nav.php";
    ?>
    <div id="page-wrapper">
        <br>
        <!--categorias-->
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Parceiro
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped data_table">
                        <thead>
                        <th>id</th>
                        <th>Nome/Razão</th>
                        <th>Apelido/Fantasia</th>
                        <th>CPF</th>
                        <th>Fone 1</th>
                        <th>Fone 2</th>
                        <th>
                            <div class='btn-group btn-group-xs' role='group'><a href='detalhe_parceiro.php?codigo=0' class='btn btn-primary'  title='Cadastrar novo cliente'><span class='glyphicon glyphicon-plus'></span></a></div>
                        </th>
                        </thead>
                        <tbody>

                        <?php

                        $sql = "SELECT codigo,nome_razao,apelido_fantasia,cpf_cnpj,tel_1,tel_2 FROM parceiros a WHERE a.ativo='true'";

                        $bd->query($sql);
                        $resposta =  $bd->getResult();
                        if (mysql_num_rows($resposta) > 0) {
                            $out = "";
                            while ($row = mysql_fetch_row($resposta)) {
                                $out .= "<tr>";
                                for( $i=0; $i<count($row);$i++){
                                    $td = $row[$i];
                                    $out .= "<td>".$td."</td>";
                                }
                                $out .= "<td><div class='btn-group btn-group-xs' role='group'><a href='detalhe_parceiro.php?codigo=$row[0]' class='btn btn-info'  title='Informações do Cliente'><span class='glyphicon glyphicon-info-sign'></span></a></div></td>";
                                $out .= "</tr>";
                            };
                            echo $out;
                        };
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/categorias-->

    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<?php
include_once "scripts.php";
?>

</body>
</html>
