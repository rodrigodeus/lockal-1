<?php
require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT * FROM representantes WHERE codigo=" . $_GET['codigo'];
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
        <form action="../backend/update_representante.php" method="post" enctype="multipart/form-data">
            <br>
            <!--Representantes-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Representantes</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Selecione um arquivo</label>
                                <input type="file" class="form-control" name="logo" id="logo" accept="image/*">
                                <br>
                                <?php
                                if ($_GET['codigo'] == 0) {
                                    $logo = '../dist/img/representantes/padrao.png';
                                }
                                echo "<img src='$logo' alt='' width='250px'>";
                                ?>
                                <hr>

                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="">Id</label>
                                        <input type="text" id="id" name="id" readonly class="form-control"
                                               value="<?= $codigo ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Nome Fantasia</label>
                                        <input type="text" id="fantasia" name="fantasia" class="form-control"
                                               value="<?= $fantasia ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Razão Social</label>
                                        <input type="text" id="razao" name="razao" class="form-control"
                                               value="<?= $razao ?>">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">CNPJ</label>
                                        <input type="text" id="cnpj" name="cnpj" class="form-control"
                                               value="<?= $cnpj ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Inscrição Estadual</label>
                                        <input type="text" id="insc_est" name="insc_est" class="form-control"
                                               value="<?= $insc_est ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">CEP</label>
                                        <input type="number" maxlength="8" id="cep" name="cep" class="form-control"
                                               placeholder="Buscar" value="<?= $cep ?>"
                                               onblur="buscar_cep(this.value)">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Endereço </label>
                                        <input type="text" id="endereco" name="endereco" class="form-control"
                                               value="<?= $endereco ?>" onblur="meu_mapa()">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="">Número</label>
                                        <input type="text" id="numero" name="numero"
                                               class="form-control" value="<?= $numero ?> " onblur="meu_mapa()">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Complemento</label>
                                        <input type="text" id="complemento" name="complemento"
                                               class="form-control" value="<?= $complemento ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="">Bairro</label>
                                        <input type="text" id="bairro" name="bairro" class="form-control"
                                               value="<?= $bairro ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label for="">Cidade </label>
                                        <input type="text" id="cidade" name="cidade" class="form-control"
                                               value="<?= $cidade ?>" onblur="meu_mapa()">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">UF</label>
                                        <?php
                                        $consulta = "SELECT sigla,sigla FROM estados";
                                        $nome = "uf";
                                        $itemPadrao = $uf;
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Fone 1</label>
                                        <input type="text" id="fone1" name="fone1" class="form-control"
                                               value="<?= $fone1 ?>">

                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Fone 2</label>
                                        <input type="text" id="fone2" name="fone2" class="form-control"
                                               value="<?= $fone2 ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Email </label>
                                        <input class="form-control" placeholder="E-mail" name="email" id="email"
                                               type="email" value="<?= $email ?>">
                                    </div>


                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Website </label>
                                        <input type="text" id="site" name="site" class="form-control"
                                               value="<?= $site ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Horário de Funcionamento</label>
                                        <textarea rows="6" id="funcionamento" name="funcionamento"
                                                  class="form-control"><?= $funcionamento ?></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Linha de Representação</label>
                                        <?php
                                        $consulta = "select 0 codigo,'Todas'  linhas union all select codigo,descricao linhas
                                              FROM linhas";
                                        $nome = "linha";
                                        $itemPadrao = $linha;
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-lg btn-primary pull-right">Salvar
                                                </button>
                                                <button type="button" onclick="excluir_representante(<?=$_GET['codigo']?>)" class="btn btn-xs btn-danger">Excluir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--localizaçãp-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Localização</div>
                            <div class="panel-body">

                                <div id="map-canvas" style="height: 350px; width: auto"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/localizaçao-->


            </div>
            <!-- /#page-wrapper -->
        </form>
    </div>
    <!-- /#wrapper -->

    <?php
    include_once "scripts.php";
    ?>


</body>
</html>
