<?php
require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT a.*,b.apelido_fantasia nome_parceiro
FROM clientes a
JOIN parceiros b ON b.codigo=a.cod_parceiro
WHERE a.ativo='true'
AND a.codigo=" . $_GET['codigo'];
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
    <?php print_r($resposta[0]); ?>

    <?php
    include_once "nav.php";
    ?>
    <div id="page-wrapper">
        <?php
        if (isset($_GET['r'])) {
            $action = "../backend/update_clientes.php?r=1";
        } else {
            $action = "../backend/update_clientes.php";
        }

        ?>
        <form action=<?= $action ?> method="post" enctype="multipart/form-data">
            <br>
            <!--Clientes-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Cliente</div>
                    <div class="panel-body">
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
                                        <label for="obs">Observações</label>
                                        <textarea type="text" id="obs" name="obs" class="form-control"
                                                  value="<?= @$obs ?>" rows="5"></textarea>

                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Contato-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Contato para caso de Emergência</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="contato_nome">Nome</label>
                                        <input type="text" id="contato_nome" name="contato_nome" class="form-control"
                                               value="<?= @$contato_nome ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="contato_parentesco">Relação</label>
                                        <input type="text" id="contato_parentesco" name="contato_parentesco"
                                               class="form-control"
                                               value="<?= @$contato_parentesco ?>"
                                               placeholder="pai,mão,irmão,vizinho...">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="contato_tel_1">Fone 1</label>
                                        <input type="text" id="contato_tel_1" name="contato_tel_1" class="form-control"
                                               value="<?= @$contato_tel_1 ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="contato_tel_2">Fone 2</label>
                                        <input type="text" id="contato_tel_2" name="contato_tel_2" class="form-control"
                                               value="<?= @$contato_tel_2 ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="contato_email">Email </label>
                                        <input class="form-control" placeholder="E-mail" name="contato_email"
                                               id="contato_email"
                                               type="email" value="<?= @$contato_email ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Contratos-->
            <?php
            $sql = "SELECT a.codigo, a.data_instalacao, a.ativo,a.data_vencimento,
                                b.nome nome_veiculo, c.nome nome_marca ,
                                d.nome_razao nome_parceiro
                                FROM contratos a
                                JOIN veiculos b ON b.codigo = a.cod_veiculo
                                JOIN marcas c ON c.codigo = a.cod_fabricante
                                JOIN parceiros d ON d.codigo = a.cod_parceiro
                                WHERE cod_cliente=" . $_GET['codigo'];
            $bd->query($sql);
            $result = $bd->getResult('array');
            if ($result) {
                ?>
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Contratos</div>
                        <div class="panel-body">
                            <div>

                                <div class="accordion" id="accordion1">
                                    <div class="accordion-group">
                                        <?php
                                        $i = 0;
                                        foreach ($result as $r) {
                                            $i++;
                                            ?>
                                            <div class="accordion-heading">

                                                <table class="table table-striped data_table" style="width:100%">
                                                    <tr>
                                                        <td><a class="accordion-toggle" data-toggle="collapse"
                                                               data-parent="#accordion1" href="#collapse<?= $i ?>"
                                                               style="text-decoration: none"><i
                                                                    class="fa fa-plus-square"></i></a></td>
                                                        <td><strong>Contrato:</strong><?= $r['codigo'] ?></td>
                                                        <td>
                                                            <strong>Aquisição:</strong><?= date('d/m/Y', strtotime($r['data_instalacao'])); ?>
                                                        </td>
                                                        <td><strong>Marca: </strong><?= $r['nome_marca'] ?></td>
                                                        <td><strong>Veículo: </strong><?= $r['nome_veiculo'] ?></td>
                                                        <td><strong>Parceiro:</strong><?= $r['nome_parceiro'] ?>
                                                        <td><strong>Status:</strong>
                                                            <?php
                                                            if ($r['ativo'] == 'true') {
                                                                if (strtotime($r['data_vencimento']) > strtotime(date('Y-m-d'))) {
                                                                    echo "Ativo";
                                                                } else {
                                                                    echo "Finalizado";
                                                                }
                                                            } else {
                                                                echo "Cancelado";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><strong>Abrir:</strong><a class="btn btn-primary btn-xs"
                                                                                      href="detalhe_contrato.php?codigo=<?= $r['codigo']; ?>"><i
                                                                    class="fa fa-share"></i></a>
                                                </table>
                                            </div>
                                            <div id="collapse<?= $i ?>" class="accordion-body collapse">
                                                <div class="accordion-inner">
                                                    <table class="table table-striped data_table" style="width:100%">
                                                        <tr>
                                                            <th><strong>Vencimento</strong></th>
                                                            <th><strong>Parcela</strong></th>
                                                            <th><strong>Valor</strong></th>
                                                            <th><strong>Data Pagamento</strong></th>
                                                            <th><strong>Pagamento</strong></th>
                                                        </tr>
                                                        <?php
                                                        $sql_1 = "SELECT * FROM fin_receber WHERE ativo='true' AND cod_contrato = {$r['codigo']} ORDER BY numero_parcela";
                                                        $bd->query($sql_1);
                                                        $result_1 = $bd->getResult("array");

                                                        if ($result_1) {

                                                            foreach ($result_1 as $r_1) {
                                                                $class = "";
                                                                $status = "";
                                                                if (strtotime($r_1['data_baixa'])) {
                                                                    if (strtotime($r_1['data_baixa']) > strtotime($r_1['vencimento'])) {
                                                                        $class = "warning";
                                                                        $status = "Pago com atraso";
                                                                    } else {
                                                                        $class = "success";
                                                                        $status = "Pago";
                                                                    }
                                                                } elseif (strtotime(date('Y-m-d')) > strtotime($r_1['vencimento'])) {
                                                                    $class = "danger";
                                                                    $status = "Falta pagamento";
                                                                }
                                                                ?>
                                                                <tr class="<?= $class ?>">
                                                                    <td><?= date('d/m/Y', strtotime($r_1['vencimento'])); ?></td>
                                                                    <td><?= $r_1['numero_parcela'] ?>
                                                                        / <?= count($result_1) ?></td>
                                                                    <td><?= str_replace(".", ",", $r_1['valor']) ?></td>
                                                                    <td><?= (date('d/m/Y', strtotime($r_1['data_baixa'])) == "01/01/1970") ? " - " : date('d/m/Y', strtotime($r_1['data_baixa'])); ?></td>
                                                                    <td><?= $status ?></td>
                                                                </tr>
                                                            <?php }
                                                        }
                                                        ?>

                                                    </table>
                                                </div>
                                            </div>
                                        <?php }; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php }; ?>

            <!--Botoes-->
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-primary pull-right">Salvar
                        </button>
                        <button type="button" onclick="excluir_cliente(<?= $_GET['codigo'] ?>)"
                                class="btn btn-xs btn-danger">Excluir
                        </button>
                    </div>
                </div>
            </div>
            <br>

        </form>
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
    <!-- /#wrapper -->


    <?php
    include_once "scripts.php";
    ?>


</body>
</html>
