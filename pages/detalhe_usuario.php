<?php
require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT email,senha,admin FROM usuarios WHERE ativo='true' AND codigo=" . $_GET['codigo'];
$bd->query($sql);
$resposta = $bd->getResult("array");
extract($resposta[0]);
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
        <form action="../backend/update_usuario.php" method="post" enctype="multipart/form-data">
            <br>
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Usuário</div>
                    <div class="panel-body">
                        <div class="row">
                            <input name="id" type="hidden" value="<?=$_GET['codigo']?>">
                            <div class="col-md-4">
                                <label for="">Email</label>
                                <input type='email' value='<?php echo $email?>' name='email' class="form-control">
                            </div>
                            <input name="id" type="hidden" value="<?=$_GET['codigo']?>">
                            <div class="col-md-4">
                                <label for="">Senha</label>
                                <input type='text' value='<?php echo $senha?>' name='senha' class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="">Administrador</label><br>
                                <input type='checkbox' <?=$admin=($admin=='true')?'checked':'';?> name='admin'>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-lg btn-primary pull-right">Salvar</button>
                                <button type="button" onclick="excluir_usuario(<?=$_GET['codigo']?>)" class="btn btn-xs btn-danger">Excluir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /#wrapper -->

    <?php
    include_once "scripts.php";
    ?>


</body>
</html>
