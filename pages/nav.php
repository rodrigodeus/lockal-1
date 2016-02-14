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
                    <div class="input-group custom-search-form" >
                        <input type="text" class="form-control" placeholder="Busca produto..." id="pesquisa_1" onkeypress="enter_geral()">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="pesquisageral()">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="produtos.php"><i class="fa fa-car fa-fw"></i> Clientes</a>
                </li>
                <li>
                    <a href="representantes.php"><i class="fa fa-users fa-fw"></i> Parceiros</a>
                </li>
                <li>
                    <a href="geral.php"><i class="fa fa-cogs fa-fw"></i> Pré Venda</a>
                </li>

                <li>
                    <a href="pesquisa.php"><i class="fa fa-search fa-fw" ></i> Pesquisa</a>
                </li>
                <?php
                    if($_SESSION['admin']=='true'){
                        echo "<li><a href='usuarios.php'><i class='fa fa-user fa-fw'></i> Usuários</a></li>";
                    }
                ?>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>

