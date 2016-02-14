<?php
    require_once "../backend/first_all.php";
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
            include "nav.php";
        ?>
        <div id="page-wrapper">

            <!--Aplicação-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Aplicação
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-striped data_table">
                            <thead>
                                <th>id</th>
                                <th>Descrição</th>
                                <th>
                                    <div class='btn-group btn-group-xs' role='group'><a href='detalhe_aplicacao.php?codigo=0' class='btn btn-primary'  title='Adicionar aplicação'><span class='glyphicon glyphicon-plus'></span></a></div>
                                </th>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT codigo, descricao FROM aplicacao WHERE ativo='true'";
                            $bd->query($sql);
                            $rs = $bd->getResult();

                            if (mysql_num_rows($rs) > 0) {
                                $out = "";
                                while ($row = mysql_fetch_row($rs)) {
                                    $out .= "<tr>";
                                    foreach( $row as $td){
                                        $out .= "<td>$td</td>";
                                    }
                                    $out .= "<td><div class='btn-group btn-group-xs' role='group'><a href='detalhe_aplicacao.php?codigo=$row[0]' class='btn btn-info'  title='Informações da aplicação'><span class='glyphicon glyphicon-info-sign'></span></a></div></td>";
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
            <!--/Aplicação-->

            <!--Fabricante-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Fabricante
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-striped data_table">
                            <thead>
                            <th>id</th>
                            <th>Descrição</th>
                            <th>
                                <div class='btn-group btn-group-xs' role='group'><a href='detalhe_fabricante.php?codigo=0' class='btn btn-primary'  title='Adicionar fabricante'><span class='glyphicon glyphicon-plus'></span></a></div>
                            </th>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT codigo, nome FROM fabricantes WHERE ativo='true'";
                            $bd->query($sql);
                            $rs = $bd->getResult();

                            if (mysql_num_rows($rs) > 0) {
                                $out = "";
                                while ($row = mysql_fetch_row($rs)) {
                                    $out .= "<tr>";
                                    foreach( $row as $td){
                                        $out .= "<td>$td</td>";
                                    }
                                    $out .= "<td><div class='btn-group btn-group-xs' role='group'><a href='detalhe_fabricante.php?codigo=$row[0]' class='btn btn-info'  title='Informações do fabricante'><span class='glyphicon glyphicon-info-sign'></span></a></div></td>";
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
            <!--/Fabricante-->

            <!--Veículos-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Veículos
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table class="table table-striped data_table">
                            <thead>
                            <th>id</th>
                            <th>Fabricante</th>
                            <th>Modelo</th>
                            <th>
                                <div class='btn-group btn-group-xs' role='group'><a href='detalhe_veiculo.php?codigo=0' class='btn btn-primary'  title='Adicionar modelo de carro'><span class='glyphicon glyphicon-plus'></span></a></div>
                            </th>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT a.codigo, b.nome, a.nome FROM veiculos a JOIN fabricantes b ON a.cod_fabricante=b.codigo WHERE a.ativo='true'";
                            $bd->query($sql);
                            $rs = $bd->getResult();

                            if (mysql_num_rows($rs) > 0) {
                                $out = "";
                                while ($row = mysql_fetch_row($rs)) {
                                    $out .= "<tr>";
                                    foreach( $row as $td){
                                        $out .= "<td>$td</td>";
                                    }
                                    $out .= "<td><div class='btn-group btn-group-xs' role='group'><a href='detalhe_veiculo.php?codigo=$row[0]' class='btn btn-info'  title='Informações do modelo de carro'><span class='glyphicon glyphicon-info-sign'></span></a></div></td>";
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
            <!--/Veículos-->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

<?php
    include_once "scripts.php";
?>

</body>
</html>
