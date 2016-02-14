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
                    Clientes
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
                        <th>Parceiro</th>
                        <th>

                            <div class='btn-group btn-group-xs' role='group'><a href='detalhe_representante.php?codigo=0' class='btn btn-primary'  title='Informações do produto'><span class='glyphicon glyphicon-plus'></span></a></div>

                        </th>
                        </thead>
                        <tbody>

                        <?php

                        $sql = "SELECT codigo id, nome_razao,apelido_fantasia,cpf,fone1,fone2,
                              if(a.cod_parceiro=0,'Lockal',(select apelido_fantasia from parceiros a where codigo=a.cod_parceiro))parceiro,' ' icon from clientes a WHERE a.ativo='true'";

                        $bd->query($sql);
                        $resposta =  $bd->getResult();
                        if (mysql_num_rows($resposta) > 0) {
                            $out = "";
                            while ($row = mysql_fetch_row($resposta)) {
                                $out .= "<tr>";

                                for( $i=0; $i<count($row);$i++){

                                    $td = $row[$i];


                                    if($i+1==count($row)){
                                        $td= "<div class='btn-group btn-group-xs' role='group'><a href='detalhe_representante.php?codigo=$row[0]' class='btn btn-info'  title='Informações do representantes'><span class='glyphicon glyphicon-info-sign'></span></a></div>";
                                    }

                                    $out .= "<td>".$td."</td>";
                                }
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
