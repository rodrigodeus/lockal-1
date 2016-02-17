<?php
require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT a.*,b.apelido_fantasia nome_parceiro, b.codigo cod_parceiro FROM clientes a left join parceiros b on b.codigo=a.cod_parceiro WHERE a.codigo=" . $_GET['codigo'];
$bd->query($sql);
$resposta = $bd->getResult("array");

if($resposta) {
    extract($resposta[0]);
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
        <form action="../backend/update_clientes.php" method="post" enctype="multipart/form-data">
            <br>
            <!--Representantes-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Clientes</div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="id">Id</label>
                                        <input type="text" id="id" name="id" readonly class="form-control"
                                               value="<?=$_GET['codigo']?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="nome_razao">Nome / Razão Social</label>
                                        <input type="text" id="nome_razao" name="nome_razao" class="form-control"
                                               value="<?= @$nome_razao ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="apelido_fantasia">Apelido/ Nome Fantasia</label>
                                        <input type="text" id="apelido_fantasia" name="apelido_fantasia" class="form-control"
                                               value="<?= @$apelido_fantasia ?>">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="cpf_cnpj">CPF/CNPJ</label>
                                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control"
                                               value="<?= @$cpf_cnpj ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="rg_insc_est">RG/Insc. Estadual</label>
                                        <input type="text" id="rg_insc_est" name="rg_insc_est" class="form-control"
                                               value="<?= @$rg_insc_est ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="rg_insc_est">Parceiro ID</label>
                                        <input type="text" id="" name="" class="form-control" disabled
                                               value="<?= @$cod_parceiro ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="rg_insc_est">Parceiro Nome</label>
                                        <input type="text" id="" name="" class="form-control" disabled
                                               value="<?= @$nome_parceiro ?>">
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
                                        <label for="endereco">Endereço </label>
                                        <input type="text" id="endereco" name="endereco" class="form-control"
                                               value="<?= @$endereco ?>" onblur="meu_mapa()">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="numero">Número</label>
                                        <input type="text" id="numero" name="numero"
                                               class="form-control" value="<?= @$numero ?> " onblur="meu_mapa()">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" id="complemento" name="complemento"
                                               class="form-control" value="<?= @$complemento ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" id="bairro" name="bairro" class="form-control"
                                               value="<?= @$bairro ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label for="cidade">Cidade </label>
                                        <input type="text" id="cidade" name="cidade" class="form-control"
                                               value="<?= @$cidade ?>" onblur="meu_mapa()">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">UF</label>
                                        <?php
                                        $consulta = "SELECT sigla,sigla FROM estados";
                                        $nome = "uf";
                                        $itemPadrao = @$uf;
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Fone 1</label>
                                        <input type="text" id="fone1" name="tel_1" class="form-control"
                                               value="<?= @$tel_1 ?>">

                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Fone 2</label>
                                        <input type="text" id="fone2" name="tel_2" class="form-control"
                                               value="<?= @$tel_2 ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Email </label>
                                        <input class="form-control" placeholder="E-mail" name="email" id="email"
                                               type="email" value="<?= @$email ?>">
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
                                                <button type="button" onclick="excluir_cliente(<?=$_GET['codigo']?>)" class="btn btn-xs btn-danger">Excluir</button>
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
                            <div class="panel-heading">Contratações</div>
                            <div class="panel-body">





                                            <div>

                                                <div class="accordion" id="accordion1">
                                                    <div class="accordion-group">
                                                        <div class="accordion-heading">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" style="text-decoration: none">
                                                                <table class="table table-striped data_table" style="width:100%">
                                                                    <tr>
                                                                        <td><i class="fa fa-plus-square"></i></td>
                                                                        <td><strong>Contrato:</strong>1001</td>
                                                                        <td><strong>Aquisição:</strong> 02/05/2015</td>
                                                                        <td><strong>Veículo: </strong>BMW X5 DME1345</td>
                                                                        <td><strong>Parceiro:</strong>Mota Auto Elétrico</td>
                                                                        <td><strong>Status: </strong>Ativo</td>

                                                                    </tr>
                                                                    </table>
                                                            </a>
                                                        </div>
                                                        <div id="collapseOne" class="accordion-body collapse in">
                                                            <div class="accordion-inner">
                                                                <table class="table table-striped data_table" style="width:100%">

                                                                    <tr>
                                                                        <th><strong>Vencimento</strong></th>
                                                                        <th><strong>Descrição</strong></th>
                                                                        <th><strong>Valor</strong></th>
                                                                        <th><strong>Data Pagamento</strong></th>
                                                                        <th><strong>Status</strong></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>01/02/2015</td>
                                                                        <td>Rastreador XYZ parcela 1/3</td>
                                                                        <td>124,55</td>
                                                                        <td>02/03/2015</td>
                                                                        <td>Pago</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>01/02/2015</td>
                                                                        <td>Rastreador XYZ parcela 1/3</td>
                                                                        <td>124,55</td>
                                                                        <td>02/03/2015</td>
                                                                        <td>Pago</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <hr>




                                            </div>

                                                <div class="accordion" id="accordion2">
                                                    <div class="accordion-group">
                                                        <div class="accordion-heading">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" style="text-decoration: none">
                                                                <table class="table table-striped data_table" style="width:100%">
                                                                    <tr>
                                                                        <td><i class="fa fa-plus-square"></i></td>
                                                                        <td><strong>Contrato:</strong>1001</td>
                                                                        <td><strong>Aquisição:</strong> 02/05/2015</td>
                                                                        <td><strong>Veículo: </strong>BMW X5 DME1345</td>
                                                                        <td><strong>Parceiro:</strong>Mota Auto Elétrico</td>
                                                                        <td><strong>Status: </strong>Ativo</td>

                                                                    </tr>
                                                                </table>
                                                            </a>
                                                        </div>
                                                        <div id="collapseOne2" class="accordion-body collapse in">
                                                            <div class="accordion-inner">
                                                                <table class="table table-striped data_table" style="width:100%">

                                                                    <tr>
                                                                        <th><strong>Vencimento</strong></th>
                                                                        <th><strong>Descrição</strong></th>
                                                                        <th><strong>Valor</strong></th>
                                                                        <th><strong>Data Pagamento</strong></th>
                                                                        <th><strong>Status</strong></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>01/02/2015</td>
                                                                        <td>Rastreador XYZ parcela 1/3</td>
                                                                        <td>124,55</td>
                                                                        <td>02/03/2015</td>
                                                                        <td>Pago</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>01/02/2015</td>
                                                                        <td>Rastreador XYZ parcela 1/3</td>
                                                                        <td>124,55</td>
                                                                        <td>02/03/2015</td>
                                                                        <td>Pago</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <hr>




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
