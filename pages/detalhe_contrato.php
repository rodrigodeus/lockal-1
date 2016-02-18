<?php
require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT a.*,b.apelido_fantasia parceiro FROM clientes a left join parceiros b on b.codigo=a.cod_parceiro WHERE a.codigo=" . $_GET['codigo'];
$bd->query($sql);
$resposta = $bd->getResult("array");

if ($resposta) {
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
        <div class="container-fluid">
        <div class="row">
            <form action="../backend/update_clientes.php" method="post" enctype="multipart/form-data">
                <br>
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Clientes
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input id="ipt_pesquisa_cliente" type="text" class="form-control" placeholder="Perquisar cliente">
                                    <span class="input-group-btn">
                                        <button onclick="fn_pesquisa_cliente()" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="id">Id</label>
                                            <input type="text" id="id" name="id" readonly class="form-control"
                                                   value="<?= $_GET['codigo'] ?>">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="nome_razao">Nome / Razão Social</label>
                                            <input type="text" id="nome_razao" name="nome_razao" class="form-control"
                                                   value="<?= @$nome_razao ?>">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="apelido_fantasia">Apelido/ Nome Fantasia</label>
                                            <input type="text" id="apelido_fantasia" name="apelido_fantasia"
                                                   class="form-control"
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
                                                    <button type="submit" class="btn btn-lg btn-primary pull-right">
                                                        Salvar
                                                    </button>
                                                    <button type="button"
                                                            onclick="excluir_cliente(<?= $_GET['codigo'] ?>)"
                                                            class="btn btn-xs btn-danger">Excluir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <div class="row">
        <form action="../backend/update_contrato.php" method="post" enctype="multipart/form-data">
            <br>

            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Clientes
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-striped data_table">
                            <thead>
                            <th>id</th>
                            <th>Nome/Razão</th>
                            <th>Apelido/Fantasia</th>
                            <th>CPF</th>
                            <th>Fone 1</th>
                            <th>Fone 2</th>
                            <th>Parceiro</th>
                            <th>

                                <div class='btn-group btn-group-xs' role='group'><a href='detalhe_cliente.php?codigo=0'
                                                                                    class='btn btn-primary'
                                                                                    title='Cadastrar novo cliente'><span
                                            class='glyphicon glyphicon-plus'></span></a></div>

                            </th>
                            </thead>
                            <tbody>

                            <?php

                            $sql = "SELECT codigo id, nome_razao,apelido_fantasia,cpf_cnpj,tel_1,tel_2,
                              if(a.cod_parceiro=0,'Lockal',(select apelido_fantasia from parceiros a where codigo=a.cod_parceiro))parceiro,' ' icon from clientes a WHERE a.ativo='true'";

                            $bd->query($sql);
                            $resposta = $bd->getResult();
                            if (mysql_num_rows($resposta) > 0) {
                                $out = "";
                                while ($row = mysql_fetch_row($resposta)) {
                                    $out .= "<tr>";

                                    for ($i = 0; $i < count($row); $i++) {

                                        $td = $row[$i];


                                        if ($i + 1 == count($row)) {
                                            $td = "<div class='btn-group btn-group-xs' role='group'><a href='detalhe_cliente.php?codigo=$row[0]' class='btn btn-info'  title='Informações do Cliente'><span class='glyphicon glyphicon-info-sign'></span></a></div>";
                                        }

                                        $out .= "<td>" . $td . "</td>";
                                    }
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
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Cadastramento de Contratos</div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="id">Contrato</label>
                                        <input type="text" id="contrato" name="contrato" readonly class="form-control"
                                               value="<?= $_GET['codigo'] ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="nome_razao">CPF/CNPJ</label>
                                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control"
                                               value="<?= @$cpf_cnpj ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="nome_razao">Nome / Razão Social</label>
                                        <input type="text" id="nome_razao" name="nome_razao" class="form-control"
                                               value="<?= @$nome_razao ?>">
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-7">
                                        <label for="apelido_fantasia">Apelido/ Nome Fantasia</label>
                                        <input type="text" id="apelido_fantasia" name="apelido_fantasia"
                                               class="form-control"
                                               value="<?= @$apelido_fantasia ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="rg_insc_est">RG/Insc. Estadual</label>
                                        <input type="text" id="rg_insc_est" name="rg_insc_est" class="form-control"
                                               value="<?= @$rg_insc_est ?>">
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
                                            <a class="accordion-toggle" data-toggle="collapse"
                                               data-parent="#accordion1" href="#collapseOne"
                                               style="text-decoration: none">
                                                <table class="table table-striped data_table" style="width:100%">
                                                    <tr>
                                                        <td><i class="fa fa-plus-square"></i></td>
                                                        <td><strong>Contrato:</strong>1001</td>
                                                        <td><strong>Aquisição:</strong> 02/05/2015</td>
                                                        <td><strong>Veículo: </strong>BMW X5 DME1345</td>
                                                        <td><strong>Parceiro:</strong>Mota Auto Elétrico</td>
                                                        <td><strong>Status: </strong>Ativo</td>
                                                        <td><i class="fa fa-print"
                                                               title="Imprimir dados deste contrato"></i>

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
                                            <a class="accordion-toggle" data-toggle="collapse"
                                               data-parent="#accordion2" href="#collapseOne2"
                                               style="text-decoration: none">
                                                <table class="table table-striped data_table" style="width:100%">
                                                    <tr>
                                                        <td><i class="fa fa-plus-square"></i></td>
                                                        <td><strong>Contrato:</strong>1001</td>
                                                        <td><strong>Aquisição:</strong> 02/05/2015</td>
                                                        <td><strong>Veículo: </strong>BMW X5 DME1345</td>
                                                        <td><strong>Parceiro:</strong>Mota Auto Elétrico</td>
                                                        <td><strong>Status: </strong>Ativo</td>
                                                        <td><i class="fa fa-print"
                                                               title="Imprimir dados deste contrato"></i>

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
                            <p><a class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                  data-target="#modal_incluir" role="button">Adicionar Contrato</a></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-12">

                                    <button type="submit" class="btn btn-primary">Gerar Contrato</button>
                                    <Br>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#page-wrapper -->
                </div>
            </div>
        </form>
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once "scripts.php";
    ?>


</body>
</html>
