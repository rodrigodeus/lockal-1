<?php
    require_once "../backend/first_all.php";
    $bd = new BD();

    //Caso o usuário não tenha o perfil de administrador
    if($_SESSION['admin']!='true'){
        session_start();
        session_destroy();
        $bd->record_log("log_login",'acesso aos usuários sem permissão');
        header('Location: login.php');
    }
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
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Aplicação
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-striped data_table">
                            <thead>
                                <th>Id</th>
                                <th>Email</th>
                                <th>Senha</th>
                                <th>Administrador</th>
                                <th>
                                    <div class='btn-group btn-group-xs' role='group'><a href='detalhe_usuario.php?codigo=0' class='btn btn-primary'  title='Adicionar usuário'><span class='glyphicon glyphicon-plus'></span></a></div>
                                </th>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT codigo,email,senha,admin FROM usuarios WHERE ativo='true'";
                            $bd->query($sql);
                            $rs = $bd->getResult();

                            if (mysql_num_rows($rs) > 0) {
                                $out = "";
                                while ($row = mysql_fetch_row($rs)) {
                                    $out .= "<tr>";
                                    foreach( $row as $td){
                                        switch ($td) {
                                            case 'true':
                                                $td = "Sim";
                                                break;
                                            case 'false':
                                                $td = "Não";
                                                break;
                                        }
                                        $out .= "<td>$td</td>";
                                    }
                                    $out .= "<td><div class='btn-group btn-group-xs' role='group'><a href='detalhe_usuario.php?codigo=$row[0]' class='btn btn-info'  title='Informações do usuário'><span class='glyphicon glyphicon-info-sign'></span></a></div></td>";
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
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

<?php
    include_once "scripts.php";
?>

</body>
</html>
