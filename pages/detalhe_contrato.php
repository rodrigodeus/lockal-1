<?php

require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT a.*,b.apelido_fantasia nome_parceiro,
        c.codigo cod_cliente, c.apelido_fantasia, c.nome_razao,c.cpf_cnpj, c.rg_insc_est
        FROM contratos a
        LEFT JOIN parceiros b on b.codigo=a.cod_parceiro
        LEFT JOIN clientes c on c.codigo=a.cod_cliente
        WHERE a.codigo=" . $_GET['codigo'];
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
                <h3 class="text-right"> Contato n. <?= $_GET['codigo']; ?></h3>

                <form id="form_contrato" action="../backend/update_contratos.php" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $_GET['codigo']; ?>">
                    <br>
                    <!--Cliente-->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Cliente
                            </div>
                            <div class="panel-body">
                                <?php
                                if (@$contrato_validado == 'off' || $_SESSION['admin'] == 'true' || $_GET['codigo'] == 0) {
                                    $validado = '';//colocar required pos validacao com o cliente
                                    ?>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="data_instalacao">Pesquisar Cliente</label>

                                            <div class="input-group">
                                                <input <?= $validado ?> id="ipt_pesquisa_cliente" type="text" class="form-control"
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
                                            <a href="detalhe_cliente.php?codigo=0&r=1"
                                               class="btn btn-primary btn-group-justified">Cadastrar</a>
                                        </div>
                                    </div>
                                <?php
                                }else{
                                    $validado = 'disabled';
                                }
                                ?>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="id">Id</label>
                                                <input <?= $validado ?> readonly type="text" id="cod_cliente" name="cod_cliente"
                                                       class="form-control"
                                                       value="<?= @$cod_cliente ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label for="nome_razao">Nome / Razão Social</label>
                                                <input <?= $validado ?> disabled type="text" id="nome_razao" name="nome_razao"
                                                       class="form-control"
                                                       value="<?= @$nome_razao ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label for="apelido_fantasia">Apelido/ Nome Fantasia</label>
                                                <input <?= $validado ?> disabled type="text" id="apelido_fantasia"
                                                       name="apelido_fantasia"
                                                       class="form-control"
                                                       value="<?= @$apelido_fantasia ?>">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="cpf_cnpj">CPF/CNPJ</label>
                                                <input <?= $validado ?> disabled type="text" id="cpf_cnpj" name="cpf_cnpj"
                                                       class="form-control"
                                                       value="<?= @$cpf_cnpj ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="rg_insc_est">RG/Insc. Estadual</label>
                                                <input <?= $validado ?> disabled type="text" id="rg_insc_est" name="rg_insc_est"
                                                       class="form-control"
                                                       value="<?= @$rg_insc_est ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="cod_parceiro">Parceiro ID</label>
                                                <input <?= $validado ?> type="text" id="cod_parceiro" name="cod_parceiro"
                                                       class="form-control" readonly
                                                       value="<?= @$cod_parceiro ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="nome_parceiro">Parceiro Nome</label>
                                                <input <?= $validado ?> disabled type="text" id="nome_parceiro" name=""
                                                       class="form-control" disabled
                                                       value="<?= @$nome_parceiro ?>">
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
                                        $nome = "cod_fabricante";
                                        $itemPadrao = @$cod_fabricante;
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Veículo</label>

                                        <div id="slt_veiculos">
                                            <?php
                                            $consulta = "SELECT codigo,nome FROM veiculos ORDER BY nome";
                                            $nome = "cod_veiculo";
                                            $itemPadrao = @$cod_veiculo;
                                            $css = "form-control";
                                            echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="cor">Cor</label><br>
                                        <input <?= $validado ?> type="text" id="cor" name="cor" class="form-control"
                                               value="<?= @$cor ?>">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="placa">Placa</label>
                                        <input <?= $validado ?> type="text" id="placa" name="placa" class="form-control"
                                               value="<?= @$placa ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ano_fabricacao">Ano de Fabricação</label>
                                        <input <?= $validado ?> type="number" id="ano_fabricacao" name="ano_fabricacao"
                                               class="form-control" value="<?= @$ano_fabricacao ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ano_modelo">Ano do Modelo</label>
                                        <input <?= $validado ?> type="number" id="ano_modelo" name="ano_modelo"
                                               class="form-control" value="<?= @$ano_modelo ?>">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="chassi">Chassi</label>
                                        <input <?= $validado ?> type="text" id="chassi" name="chassi" class="form-control"
                                               value="<?= @$chassi ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="renavan">Renavan</label>
                                        <input <?= $validado ?> type="text" id="renavan" name="renavan"
                                               class="form-control" value="<?= @$renavan ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="seguradora">Seguradora</label>
                                        <input <?= $validado ?> type="text" id="seguradora" name="seguradora"
                                               class="form-control" value="<?= @$seguradora ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Rastreador-->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Dados do Rastreador
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Fabricante</label>
                                        <?php
                                        $consulta = "SELECT codigo, fabricante FROM rastreadores ORDER BY fabricante";
                                        $nome = "";
                                        $itemPadrao = @$cod_rastreador;
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="imei">IMEI</label>
                                        <input <?= $validado ?> type="text" id="imei" name="imei" class="form-control"
                                               value="<?= @$imei ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="serial">Serial</label>
                                        <input <?= $validado ?> type="text" id="serial" name="serial"
                                               class="form-control" value="<?= @$serial ?>">
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Modelo</label>

                                        <div id="slt_rastreador">
                                            <?php
                                            $consulta = "SELECT codigo,modelo FROM rastreadores ORDER BY fabricante";
                                            $nome = "cod_rastreador";
                                            $itemPadrao = @$cod_rastreador;
                                            $css = "form-control";
                                            echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="chip_1">Chip 1</label>
                                        <input <?= $validado ?> type="text" id="chip_1" name="chip_1" class="form-control"
                                               value="<?= @$chip_1 ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="chip_2">Chip 2</label>
                                        <input <?= $validado ?> type="text" id="chip_2" name="chip_2"
                                               class="form-control" value="<?= @$chip_2 ?>">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>

                    <!--Equipamento e Instalação-->
                    <div class="row" id="eq_instal">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Equipamento e Instalação
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label for="fp_dinheiro">Dinheiro</label>
                                        <input <?= $validado ?> type="text" id="fp_dinheiro" name="fp_dinheiro"
                                               class="form-control money"
                                               placeholder="0,00" value="<?= @$fp_dinheiro ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="fp_boleto">Boleto</label>
                                        <input <?= $validado ?> type="text" id="fp_boleto" name="fp_boleto" class="form-control money"
                                               placeholder="0,00" value="<?= @$fp_boleto ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="fp_deposito">Depósito</label>
                                        <input <?= $validado ?> type="text" id="fp_deposito" name="fp_deposito"
                                               class="form-control money"
                                               placeholder="0,00" value="<?= @$fp_deposito ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="fp_cheque">Cheque</label>
                                        <input <?= $validado ?> type="text" id="fp_cheque" name="fp_cheque" class="form-control money"
                                               placeholder="0,00" value="<?= @$fp_cheque ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="fp_cartao_debito">Cartão Débito</label>
                                        <input <?= $validado ?> type="text" id="fp_cartao_debito" name="fp_cartao_debito"
                                               class="form-control money" placeholder="0,00"
                                               value="<?= @$fp_cartao_debito ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label for="fp_cartao_credito">Cartão Crédito</label>
                                        <input <?= $validado ?> type="text" id="fp_cartao_credito" name="fp_cartao_credito"
                                               class="form-control money" placeholder="0,00"
                                               value="<?= @$fp_cartao_credito ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="fp_cartao_debito">Parcelas Crédito</label>
                                        <select <?= $validado ?> name="fp_parcelas_cartao" id="fp_parcelas_cartao" class="form-control">
                                            <option value="1" <?= (@$fp_parcelas_cartao == 1) ? 'selected' : '' ?>>1
                                            </option>
                                            <option value="2" <?= (@$fp_parcelas_cartao == 2) ? 'selected' : '' ?>>2
                                            </option>
                                            <option value="3" <?= (@$fp_parcelas_cartao == 3) ? 'selected' : '' ?>>3
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="valor_parcela">Valor da parcela</label>
                                        <input <?= $validado ?> type="text" id="valor_parcela" name="valor_parcela"
                                               class="form-control money"
                                               placeholder="0,00" disabled value="">
                                    </div>
                                    <div class="col-lg-offset-2 col-lg-2">
                                        <label for="fp_total">TOTAL</label>
                                        <input <?= $validado ?> type="text" id="fp_total" name="fp_total" class="form-control money"
                                               placeholder="0,00" disabled>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>

                    <!--Contrato-->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Contrato
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="data_instalacao">Data da Instalação</label>
                                        <input <?= $validado ?> type="date" id="data_instalacao" name="data_instalacao"
                                               class="form-control"
                                               value="<?= ($_GET['codigo'] == 0) ? date('Y-m-d') : $data_instalacao; ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="data_instalacao">Vencimento do Contrato</label>
                                        <input <?= $validado ?> type="date" id="data_vencimento" name="data_vencimento"
                                               class="form-control"
                                               value="<?= ($_GET['codigo'] == 0) ? date('Y-m-d', strtotime('+1 year, -1 day')) : $data_vencimento; ?>">
                                    </div>
                                    <?php
                                    if ($_SESSION['admin'] == 'true' || @$contrato_validado == 'on') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label for="cod_power">Cód. Cliente Power</label>
                                            <input <?= $validado ?> type="text" id="cod_power" name="cod_power" class="form-control"
                                                   value="<?= @$cod_power ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="contrato_validado">Validar Contrato</label><br>
                                            <input <?= $validado ?> type="checkbox" id="contrato_validado" name="contrato_validado"
                                                <?= (@$contrato_validado == 'on') ? 'checked' : '' ?>> <label
                                                for="contrato_validado">Sim</label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Mensalidade-->
                    <div class="row" id="mensalidade">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Mensalidade
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-2" id="t_mensalidade">
                                            <label class="radio">
                                                <input <?= $validado ?> type="radio" name="tipo_mensalidade"
                                                       id="" <?= (@$tipo_mensalidade == 'boleto') ? 'checked' : '' ?>
                                                       value="boleto">Boleto
                                            </label>
                                            <label class="radio">
                                                <input <?= $validado ?> type="radio" name="tipo_mensalidade"
                                                       id="" <?= (@$tipo_mensalidade == 'debito') ? 'checked' : '' ?>
                                                       value="debito">Débito
                                            </label>
                                            <label class="radio">
                                                <input <?= $validado ?> type="radio" name="tipo_mensalidade"
                                                       id="" <?= (@$tipo_mensalidade == 'credito') ? 'checked' : '' ?>
                                                       value="credito">Cartão de Crédito
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="me_total">Total do Contrato</label>
                                            <input <?= $validado ?> type="text" id="me_total" name="me_total" class="form-control money"
                                                   placeholder="0,00" value="<?= @$me_total ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="me_parcelas">Parcelas</label>
                                            <select <?= $validado ?> name="me_parcelas" id="me_parcelas"
                                                    class="form-control">
                                                <?php
                                                for ($i = 1; $i < 13; $i++) {
                                                    $selected = (@$me_parcelas == $i) ? 'selected' : '';
                                                    echo "<option value='$i' $selected >$i</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="valor_me_parcela">Valor da parcela</label>
                                            <input <?= $validado ?> type="text" id="valor_me_parcela" name="valor_me_parcela"
                                                   class="form-control money"
                                                   placeholder="0,00" disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="me_dia_vencimento">Dia 1&ordm; vencimento</label>
                                            <input <?= $validado ?> type="date" name="me_dia_vencimento" id="me_dia_vencimento"
                                                   class="form-control" value="<?= @$me_dia_vencimento ?>">

                                            <p class="text-muted">*Os dias devem ser 10, 20 ou 30 de cada mês</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="dados_conta">
                                    <hr>
                                    <div class="col-lg-2">
                                        <label for="me_banco">Banco</label>
                                        <input <?= $validado ?> type="text" id="me_banco" name="me_banco" class="form-control"
                                               value="<?= @$me_banco ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="me_agencia">Agência</label>
                                        <input <?= $validado ?> type="text" id="me_agencia" name="me_agencia" class="form-control"
                                               value="<?= @$me_agencia ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="me_conta">Conta</label>
                                        <input <?= $validado ?> type="text" id="me_conta" name="me_conta" class="form-control"
                                               value="<?= @$me_conta ?>">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>

                    <!--Observacoes-->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Observações</div>
                            <div class="panel-body">
                                <textarea <?= $validado ?> name="obs" id="" class="form-control" rows="10"><?= @$obs ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!--Dados das Parcelas-->
                    <?php if ($_GET['codigo'] != 0) { ?>

                        <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Parcelas</div>
                                <div class="panel-body">

                                    <table class="table table-striped" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th><strong>Vencimento</strong></th>
                                            <th><strong>Parcela</strong></th>
                                            <th><strong>Valor R$</strong></th>
                                            <th><strong>Data Pagamento</strong></th>
                                            <th><strong>Descrição</strong></th>
                                            <th><strong>Status</strong></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql = "SELECT * FROM fin_receber WHERE ativo='true' AND cod_contrato = {$_GET['codigo']} ORDER BY vencimento";
                                        $bd->query($sql);
                                        $result = $bd->getResult("array");
                                        foreach ($result as $r) {

                                            $class = "";
                                            $status = "";

                                            if (strtotime($r['data_baixa'])) {

                                                if (strtotime($r['data_baixa']) > strtotime($r['vencimento'])) {
                                                    $class = "warning";
                                                    $status = "Pago com atraso";
                                                } else {
                                                    $class = "success";
                                                    $status = "Pago";
                                                }
                                            } elseif (strtotime(date('Y-m-d')) > strtotime($r['vencimento'])) {
                                                $class = "danger";
                                                $status = "Falta pagamento";
                                            }
                                            ?>
                                            <tr class=" <?= $class ?>">
                                                <?php


                                                ?>
                                                <td><input <?= $validado ?> class="form-control"
                                                           name="data_vencimento_<?= $r['codigo'] ?>" type="date"
                                                           value="<?= $r['vencimento'] ?>"></td>
                                                <td>
                                                    <?php
                                                    if ($r['numero_parcela'] <= @$me_parcelas) {
                                                        echo $r['numero_parcela'] . "/" . @$me_parcelas;
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?>
                                                </td>
                                                <td><input <?= $validado ?> class="form-control money" id="xcv" type="text"
                                                           name="data_valor_<?= $r['codigo'] ?>"
                                                           value="<?= str_replace(".", ",", $r['valor']) ?>"></td>
                                                <td><input <?= $validado ?> class="form-control" type="date"
                                                           name="data_baixa_<?= $r['codigo'] ?>"
                                                           value="<?= $r['data_baixa'] ?>"></td>
                                                <td><input <?= $validado ?> class="form-control" type="text" maxlength="255"
                                                           name="data_descricao_<?= $r['codigo'] ?>"
                                                           value="<?= $r['descricao'] ?>"></td>
                                                <td><?= $status ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!--Observacoes de cancelamento do contrato-->
                    <div class="row" id="campo_obs_canc" hidden>
                        <div class="panel panel-primary">
                            <div class="panel-heading">Observações de cancelamento</div>
                            <div class="panel-body">
                                <h4>Por favor, justifique o motivo do cancelamento deste contrato</h4>

                                <p class="text-muted">*Campo obrigatório</p>
                                <textarea name="obs_cancelamento" id="obs_cancelamento" class="form-control"
                                          rows="10"><?= @$obs_cancelamento ?></textarea><br>
                                <button type="button" onclick="fn_obs_voltar()"
                                        class="btn btn-primary">Voltar
                                </button>
                                <button type="button" onclick="excluir_contrato(<?= $_GET['codigo'] ?>)"
                                        class="btn btn-xs btn-danger pull-right">Cancelar
                                </button>
                            </div>
                        </div>
                    </div>


                    <!--Botoes-->
                    <?php
                    if (@$contrato_validado == 'off' || $_SESSION['admin'] == 'true' || $_GET['codigo'] == 0) {
                        ?>
                        <div class="row" id="">
                            <button type="submit" id="btn_salvar" class="btn btn-primary pull-right">Salvar</button>
                            <button type="button" onclick="fn_obs_can()" id="btn_cancelar"
                                    class="btn btn-xs btn-danger">Cancelar
                            </button>
                        </div>
                    <?php
                    }else{ ?>
                        <div class="row">
                            <div class="alert alert-info" role="alert">
                                <strong>Contrato validado!</strong><br>
                                O contrato foi validado pelo administrador do sistema.
                                A partir de agora você só poderá visualizar as informações.
                                Para alterar qualquer informação contate o administrador.
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </form>
            </div>
        </div>

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

        <!-- Modal Loading-->
        <div class="modal fade" id="modalLoading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

        <?php
        include_once "scripts.php";
        ?>


</body>
</html>
