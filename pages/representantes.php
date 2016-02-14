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
                    Reprensentantes
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped data_table">
                        <thead>
                        <th>id</th>
                        <th>Nome Fantasia</th>
                        <th>Razão Social</th>
                        <th>Cidade</th>
                        <th>UF</th>
                        <th>Fones</th>
                        <th>Linha</th>
                        <th>

                            <div class='btn-group btn-group-xs' role='group'><a href='detalhe_representante.php?codigo=0' class='btn btn-primary'  title='Informações do produto'><span class='glyphicon glyphicon-plus'></span></a></div>

                        </th>
                        </thead>
                        <tbody>

                        <?php

                        $sql = "SELECT codigo,fantasia,razao,cidade,uf,concat(fone1,' ',fone2)fones,
                              if(a.linha=0,'Todas',(select descricao from linhas where codigo=a.linha))linha,' ' icon from representantes a WHERE a.ativo='true'";

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
