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
                    <!--Contrato-->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Contrato
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="data_instalacao">Data da Instalação</label>
                                        <input type="date" id="data_instalacao" name="data_instalacao"
                                               class="form-control" value="" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="data_instalacao">Vencimento do Contrato</label>
                                        <input type="date" id="data_vencimento" name="data_vencimento"
                                               class="form-control" value="" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="data_instalacao">Cód. Cliente Power</label>
                                        <input type="text" id="cod_power" name="cod_power" class="form-control"
                                               value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Cliente-->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Cliente
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="data_instalacao">Pesquisar Cliente</label>
                                        <div class="input-group">
                                            <input id="ipt_pesquisa_cliente" type="text" class="form-control"
                                                   placeholder="Perquisar cliente">
                                        <span class="input-group-btn">
                                            <button onclick="fn_pesquisa_cliente()" class="btn btn-primary"
                                                    type="button"><span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                        </div>
                                        <!-- /input readonly-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-2">
                                        <label for="">Cadastrar Cliente</label><br>
                                        <a href="detalhe_cliente.php?codigo=0" class="btn btn-primary btn-group-justified">Cadastrar</a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="id">Id</label>
                                                <input readonly type="text" id="cod_cliente" name="cod_cliente" class="form-control"
                                                       value="<?= $_GET['codigo'] ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label for="nome_razao">Nome / Razão Social</label>
                                                <input disabled type="text" id="nome_razao" name="nome_razao"
                                                       class="form-control"
                                                       value="<?= @$nome_razao ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label for="apelido_fantasia">Apelido/ Nome Fantasia</label>
                                                <input disabled type="text" id="apelido_fantasia"
                                                       name="apelido_fantasia"
                                                       class="form-control"
                                                       value="<?= @$apelido_fantasia ?>">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="cpf_cnpj">CPF/CNPJ</label>
                                                <input disabled type="text" id="cpf_cnpj" name="cpf_cnpj"
                                                       class="form-control"
                                                       value="<?= @$cpf_cnpj ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="rg_insc_est">RG/Insc. Estadual</label>
                                                <input disabled type="text" id="rg_insc_est" name="rg_insc_est"
                                                       class="form-control"
                                                       value="<?= @$rg_insc_est ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="rg_insc_est">Parceiro ID</label>
                                                <input disabled type="text" id="" name="" class="form-control" disabled
                                                       value="<?= @$cod_parceiro ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="rg_insc_est">Parceiro Nome</label>
                                                <input disabled type="text" id="" name="" class="form-control" disabled
                                                       value="<?= @$nome_parceiro ?>">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">CEP</label>
                                                <input disabled type="number" maxlength="8" id="cep" name="cep"
                                                       class="form-control"
                                                       placeholder="Buscar" value="<?= $cep ?>"
                                                       onblur="buscar_cep(this.value)">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="endereco">Endereço </label>
                                                <input disabled type="text" id="endereco" name="endereco"
                                                       class="form-control"
                                                       value="<?= @$endereco ?>" onblur="meu_mapa()">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="numero">Número</label>
                                                <input disabled type="text" id="numero" name="numero"
                                                       class="form-control" value="<?= @$numero ?> "
                                                       onblur="meu_mapa()">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="complemento">Complemento</label>
                                                <input disabled type="text" id="complemento" name="complemento"
                                                       class="form-control" value="<?= @$complemento ?>">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-5">
                                                <label for="bairro">Bairro</label>
                                                <input disabled type="text" id="bairro" name="bairro"
                                                       class="form-control"
                                                       value="<?= @$bairro ?>">
                                            </div>

                                            <div class="col-md-5">
                                                <label for="cidade">Cidade </label>
                                                <input disabled type="text" id="cidade" name="cidade"
                                                       class="form-control"
                                                       value="<?= @$cidade ?>" onblur="meu_mapa()">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">UF</label>
                                                <?php
                                                $consulta = "SELECT sigla,sigla FROM estados";
                                                $nome = "uf";
                                                $itemPadrao = @$uf;
                                                $css = "form-control";
                                                $js= 'disabled';
                                                echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                                ?>
                                            </div>

                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Fone 1</label>
                                                <input disabled type="text" id="fone1" name="tel_1" class="form-control"
                                                       value="<?= @$tel_1 ?>">

                                            </div>

                                            <div class="col-md-4">
                                                <label for="">Fone 2</label>
                                                <input disabled type="text" id="fone2" name="tel_2" class="form-control"
                                                       value="<?= @$tel_2 ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Email </label>
                                                <input disabled class="form-control" placeholder="E-mail" name="email"
                                                       id="email"
                                                       type="email" value="<?= @$email ?>">
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Veículo-->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Dados do Veículo
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Fabricante</label>
                                        <?php
                                        $consulta = "SELECT codigo,nome FROM marcas ORDER BY nome";
                                        $nome = "fabricante";
                                        $itemPadrao = "";
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Veículo</label>
                                        <div id="slt_veiculos">
                                            <select name="cod_veiculo" id="cod_veiculo" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="cor">Cor</label><br>
                                        <input type="text" id="cor" name="cor" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="placa">Placa</label>
                                            <input type="text" id="placa" name="placa" class="form-control">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ano_fabricacao">Ano de Fabricação</label>
                                        <input type="date" id="ano_fabricacao" name="ano_fabricacao"
                                               class="form-control" value="" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ano_modelo">Ano do Modelo</label>
                                        <input type="date" id="ano_modelo" name="ano_modelo"
                                               class="form-control" value="" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="chassi">Chassi</label>
                                        <input type="text" id="chassi" name="chassi" class="form-control">
                                </div>
                                    <div class="col-lg-4">
                                        <label for="renavan">Renavan</label>
                                        <input type="text" id="renavan" name="renavan"
                                               class="form-control" value="" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="seguradora">Seguradora</label>
                                        <input type="text" id="seguradora" name="seguradora"
                                               class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <!-- /#wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Selecione um Cliente</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalLoading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

        <?php
        include_once "scripts.php";
        ?>


</body>
</html>
