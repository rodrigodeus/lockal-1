<?php require_once "../backend/first_all.php";
$bd = new BD();

//teste do git
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include_once "head.php"; ?>

<body>

    <div id="wrapper">

        <?php
            include_once "nav.php";
        ?>
        <div id="page-wrapper">
            <br>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-car fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php

                                        $sql = "SELECT codigo FROM produtos WHERE ativo='true'";
                                        $bd->query($sql);
                                        echo $bd->getNumLinha();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="produtos.php">
                            <div class="panel-footer">
                                <span class="pull-left">Produtos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php
                                        $sql = "SELECT codigo FROM representantes WHERE ativo='true'";
                                        $bd->query($sql);
                                        echo $bd->getNumLinha();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="parceiros.php">
                            <div class="panel-footer">
                                <span class="pull-left">Representantes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cogs fa-5x"></i>
                                </div>
                            </div>
                        </div>
                        <a href="geral.php">
                            <div class="panel-footer">
                                <span class="pull-left">Geral</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                </div>
                            </div>
                        </div>
                        <a href="pesquisa.php">
                            <div class="panel-footer">
                                <span class="pull-left">Pesquisa</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php
    include_once "scripts.php";
?>

</body>

</html>
