<?php
require_once "../backend/conn.php";
include_once "../backend/session.php";
include_once "../backend/injection_form.php";

$session = new Session();

if(isset($_POST['email']) && isset($_POST['password'])){
    $session->start_session($_POST['email'],$_POST['password']);
}
include "head.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Benvindo ao Módulo Administrativo </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                              <img src=""   alt='' width='300'px'>
                            </div>

                        </div>
                        <hr>
                        <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Entrar</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include "scripts.php"?>

</body>

</html>
