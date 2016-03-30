<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 13/01/2016
 * Time: 10:34
 */
?>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="index.php"><img src="../dist/img/logo.png" width="100"></a>

    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Busca..." id="pesquisa_1"
                               onkeypress="enter_geral()">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="pesquisageral()">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="clientes.php"><i class="fa fa-car fa-fw"></i> Clientes</a>
                </li>
                <?php
                if ($_SESSION['admin'] == 'true') { ?>
                    <li>
                        <a href="parceiros.php"><i class="fa fa-users fa-fw"></i> Parceiros</a>
                    </li>
                <?php } ?>
                <li>
                    <a href="contratos.php"><i class="fa fa-file-text-o fa-fw"></i> Contratos</a>
                </li>

                <li>
                    <a href="#"><i class="fa fa-money fa-fw"></i> Financeiro<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href='#'> À Receber </a></li>
                        <li><a href='#'> À Pagar </a></li>
                    </ul>
                    <!-- /.nav - second - level-->
                </li>

            </ul>
        </div>
        <!-- /.sidebar - collapse-->
    </div>
    <!-- /.navbar -static-side-->
</nav>

