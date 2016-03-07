<?php
require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT * FROM parceiros a  WHERE a.codigo=" . $_GET['codigo'];
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
        <form action="../backend/update_parceiro.php" method="post" enctype="multipart/form-data">
            <br>
            <!--Parceiros-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Parceiro</div>
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
                                    <div class="col-md-2">
                                        <label for="">Fone 1</label>
                                        <input type="text" id="fone1" name="tel_1" class="form-control"
                                               value="<?= @$tel_1 ?>">

                                    </div>

                                    <div class="col-md-2">
                                        <label for="">Fone 2</label>
                                        <input type="text" id="fone2" name="tel_2" class="form-control"
                                               value="<?= @$tel_2 ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Email </label>
                                        <input class="form-control" placeholder="E-mail" name="email" id="email"
                                               type="email" value="<?= @$email ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="senha">Senha </label>
                                        <input class="form-control" placeholder="E-mail" name="senha" id="senha"
                                               type="text" value="<?= @$senha ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="admin">Administrador </label>
                                        <input name="admin" id="admin"
                                               type="checkbox" <?= (@$admin == 'true') ? "checked" : "" ?>>

                                        <p class="text-muted"><strong>Atenção:</strong> essa opção dá acesso total ao
                                            sistema.</p>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Clientes-->
            <?php
            $sql = "SELECT a.codigo, a.apelido_fantasia, a.nome_razao, a.cpf_cnpj
                                FROM clientes a
                                WHERE a.cod_parceiro = " . $_GET['codigo'];
            $bd->query($sql);
            $result = $bd->getResult('array');
            if ($result) {
                ?>
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Clientes</div>
                        <div class="panel-body">
                            <div>
                                <table class="table table-striped data_table"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Apelido</th>
                                        <th>Nome</th>
                                        <th>CPF - CNPJ</th>
                                        <th>Abrir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($result as $r) { ?>
                                        <tr>
                                            <td><?= $r['codigo'] ?></td>
                                            <td><?= $r['apelido_fantasia'] ?></td>
                                            <td><?= $r['nome_razao'] ?></td>
                                            <td><?= $r['cpf_cnpj'] ?></td>
                                            <td><a class="btn btn-xs btn-primary"
                                                   href="detalhe_cliente.php?codigo=<?= $r['codigo'] ?>"><i
                                                        class="fa fa-share"></i></a></td>
                                        </tr>
                                    <?php }; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }; ?>

            <!--Contratos-->
            <?php
            $sql = "SELECT a.codigo, a.data_instalacao, a.cod_power,
                    b.nome_razao, b.cpf_cnpj,
                    c.nome nome_fabricante,
                    d.nome nome_veiculo
                    FROM contratos a
                    JOIN clientes b ON b.codigo=a.cod_cliente
                    JOIN marcas c ON c.codigo= a.cod_fabricante
                    JOIN veiculos d ON d.codigo=a.cod_veiculo
                    WHERE a.cod_parceiro = " . $_GET['codigo'];
            $bd->query($sql);
            $result = $bd->getResult('array');
            if ($result) {
                ?>
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Contratos</div>
                        <div class="panel-body">
                            <div>
                                <table class="table table-striped data_table"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Data instalação</th>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>Cod Power</th>
                                        <th>Fabricante</th>
                                        <th>Veículo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($result as $r) { ?>
                                        <tr>
                                            <td><?= $r['codigo'] ?></td>
                                            <td><?= $r['data_instalacao'] ?></td>
                                            <td><?= $r['nome_razao'] ?></td>
                                            <td><?= $r['cod_power'] ?></td>
                                            <td><?= $r['cpf_cnpj'] ?></td>
                                            <td><?= $r['nome_fabricante'] ?></td>
                                            <td><?= $r['nome_veiculo'] ?></td>
                                            <td><a class="btn btn-xs btn-primary"
                                                   href="detalhe_contrato.php?codigo=<?= $r['codigo'] ?>"><i
                                                        class="fa fa-share"></i></a></td>
                                        </tr>
                                    <?php }; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }; ?>



            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-lg btn-primary pull-right">Salvar
                    </button>
                    <button type="button" onclick="excluir_parceiro(<?= $_GET['codigo'] ?>)"
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
<!-- /#wrapper -->

<?php
include_once "scripts.php";
?>


</body>
</html>
