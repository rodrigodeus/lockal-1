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

        <a class="navbar-brand" href="index.php"><img src="" width="100"></a>


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
                        <input type="text" class="form-control" placeholder="Busca..." id="pesquisa_1" onkeypress="enter_geral()">
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
                    if($_SESSION['admin']=='true'){
                        echo "<li><a href='representantes.php'><i class='fa fa-users fa-fw'></i> Parceiros</a></li>";
                    }
                    ?>

                <li>
                    <a href="contratos.php"><i class="fa fa-edit fa-fw"></i>Contratos</a>
                </li>

                <?php
                    if($_SESSION['admin']=='true'){
                        echo "<li><a href='geral.php'><i class='fa fa-cogs fa-fw'></i> Configuração</a></li>";
                        echo "<li><a href='usuarios.php'><i class='fa fa-user fa-fw'></i> Usuários</a></li>";
                    }
                ?>

                <li>
                    <a href="#"><i class="fa fa-money fa-fw"></i>Financeiro<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href='#'>À Receber</a></li>
                        <li><a href='#'>À Pagar</a></li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

</ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>

