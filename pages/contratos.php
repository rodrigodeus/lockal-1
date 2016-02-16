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
               Contratos
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped data_table">
                        <thead>
                        <th>Contrato</th>
                        <th>Data Instalação</th>
                        <th>Cliente</th>
                        <th>Cod Power</th>
                        <th>Parceiro</th>
                        <th>Veiculo</th>
                        <th>Cor</th>
                        <th>ano</th>

                        <th>

                            <div class='btn-group btn-group-xs' role='group'><a href='detalhe_contrato.php?codigo=0' class='btn btn-primary'  title='Novo Contrato'><span class='glyphicon glyphicon-plus'></span></a></div>

                        </th>
                        </thead>
                        <tbody>

                        <?php

                        $sql = "select a.codigo, a.data_instalacao,b.nome_razao cliente,a.cod_power,
                                c.nome_razao parceiro,
                               concat(d.nome,' ',a.placa) veiculo,a.cor,a.ano_fabricacao ano, '' icone
                                from contratos a
                                 left join clientes b on b.codigo=a.cod_cliente
                                left join parceiros c on c.codigo=a.cod_parceiro

                                left join veiculos  d on d.codigo=a.cod_veiculo";


                        $bd->query($sql);
                        $resposta =  $bd->getResult();
                        if (mysql_num_rows($resposta) > 0) {
                            $out = "";
                            while ($row = mysql_fetch_row($resposta)) {
                                $out .= "<tr>";

                                for( $i=0; $i<count($row);$i++){

                                    $td = $row[$i];


                                    if($i+1==count($row)){
                                        $td= "<div class='btn-group btn-group-xs' role='group'><a href='detalhe_cliente.php?codigo=$row[0]' class='btn btn-info'  title='Informações do Cliente'><span class='glyphicon glyphicon-info-sign'></span></a></div>";
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
