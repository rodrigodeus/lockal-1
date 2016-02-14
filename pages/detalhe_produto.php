<?php

require_once "../backend/first_all.php";

$bd = new BD();

$sql = "SELECT a.*, b.descricao detalhamento FROM produtos a join texto b on b.id=a.cod_texto WHERE a.ativo='true' AND a.codigo=" . $_GET['codigo'];
$bd->query($sql);
$resposta = $bd->getResult("array");

extract($resposta[0]);

$json = $bd->getResult("json");

?>

<!DOCTYPE html>
<html lang="pt-BR" xmlns="http://www.w3.org/1999/html">

<?php
include_once "head.php";
?>

<body>

<div id="wrapper">

    <?php
    include_once "nav.php";
    ?>
    <div id="page-wrapper">
        <form action="../backend/update_produto.php" method="post" enctype="multipart/form-data" id="form_det_produto">
            <br>
            <!--categorias-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">

                            <div class="col-md-11">
                                <?= $nome_produto ?>
                            </div>
                            <div class="col-md-1">

                                <a href="javascript:history.back();" style="color:#ffffff; text-decoration: none" >Voltar</a>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Selecione uma imagem <i class="fa fa-cog "></i></label>
                                <hr>
                                <?php

                                if ($_GET['codigo'] == 0) {
                                    $url = "../dist/img/produtos/imagem_padrao.png";
                                    echo "<input type='hidden' name='url' id='url' value='$url'>";
                                }else{
                                    $sql = "SELECT url FROM produtos WHERE ativo='true' AND codigo=".$_GET['codigo'];
                                    $bd->query($sql);
                                    $rs = $bd->getResult();
                                    if (mysql_num_rows($rs) > 0) {
                                        $out = array();
                                        while ($row = mysql_fetch_assoc($rs)) {
                                            extract($row);
                                            echo "<input type='hidden' name='url' id='url' value='$url'>";
                                        };
                                    };
                                }
                                echo "<img src='$url' alt='' width='250px' data-toggle='modal' data-target='#modal_images' id='img_produto' style='cursor: pointer'>";

                                ?>

                                <hr>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="">Id</label>
                                        <input type="text" name="id" id="id" readonly class="form-control"
                                               value="<?= $codigo ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Nome do produto</label>
                                        <input type="text" id="nome_produto" name="nome_produto" class="form-control"
                                               value="<?= $nome_produto ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Linha</label>
                                        <?php
                                        $consulta = "SELECT codigo, descricao FROM linhas";
                                        $nome = "linha";
                                        $itemPadrao = $cod_linha;
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>


                                    <div class="col-md-3">
                                        <label for="">Família</label>
                                        <?php
                                        $consulta = "SELECT codigo, nome FROM familia where ativo='true'";
                                        $nome = "nome";
                                        $itemPadrao = $cod_familia;
                                        $css = "form-control";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                        ?>
                                    </div>



                                </div>
                                <br>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Aplicações
                                            </div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <table class="table table-striped data_table_off">
                                                    <thead>
                                                    <?php
                                                    $sql = "SELECT descricao FROM aplicacao where ativo='true' order by codigo";
                                                    $bd->query($sql);
                                                    echo $bd->getResult('th');

                                                    $sql = "SELECT codigo, descricao FROM aplicacao where ativo='true' order by codigo";
                                                    $bd->query($sql);
                                                    $my_array = $bd->getResult('array');
                                                    ?>
                                                    </thead>
                                                    <tbody>

                                                    <?php
                                                    $campos = "";
                                                    for ($i = 0; $i < count($my_array); $i++) {

                                                        if ($i >= 1) {
                                                            $vig = ',';
                                                        }
                                                        if($_GET['codigo']!= 0) {
                                                            $campos .= "$vig if((SELECT count(*) FROM produto_aplicacao c join aplicacao d on d.codigo=c.cod_aplicacao WHERE d.ativo='true' and c.cod_aplicacao = " . $my_array[$i]['codigo'] . " and c.cod_produto=a.codigo)>0,'true','') campo_$i ";
                                                        }else{
                                                            $campos .= "$vig if((SELECT count(*) FROM aplicacao c WHERE c.ativo='true' and c.codigo = " . $my_array[$i]['codigo'] . ") >0,'false','') campo_$i ";
                                                        }
                                                    }

                                                    if($_GET['codigo']!= 0) {
                                                        $sql = "SELECT $campos FROM produtos a JOIN linhas b ON b.codigo=a.cod_linha where a.ativo='true' AND a.codigo=" . $_GET['codigo'];
                                                    }else{
                                                        $sql = "SELECT $campos  from linhas limit 1";
                                                    }




                                                    $bd->query($sql);
                                                    $resposta = $bd->getResult();
                                                    if (mysql_num_rows($resposta) > 0) {
                                                        $out = "";
                                                        while ($row = mysql_fetch_row($resposta)) {
                                                            $out .= "<tr>";
                                                            for ($i = 0; $i < count($row); $i++) {
                                                                $checked = ($row[$i] == "true") ? "checked" : "";
                                                                $out .= "<td><input type='checkbox' id='aplicacao_{$my_array[$i]['codigo']}' name='aplicacao_{$my_array[$i]['codigo']}' value='{$my_array[$i]['codigo']}' $checked ></td>";
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
                                        <!--/categorias-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="">Fios</label>
                                        <input id="fios" name="fios" type="number" class="form-control" min="0"
                                               value="<?= $fios = ($_GET['codigo']==0)?0:$fios ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Descontos</label>
                                        <input id="desconto" name="desconto" type="text" class="form-control"
                                               value="<?= $desconto ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Status</label>
                                        <?php
                                        $consulta = "SELECT 'Ativo' codigo,'Ativo' status UNION All  SELECT 'Inativo' codigo,'Inativo' status UNION All SELECT 'Substituido' codigo,'Substituido' status";
                                        $nome = "status";
                                        $itemPadrao = $status;
                                        $css = "form-control";
                                        $itemZero = null;
                                        $js = 'onchange=slt_status()';
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css,$itemZero,$js);
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Substituido por</label>
                                        <?php

                                        $consulta = "SELECT codigo, nome_produto FROM produtos WHERE status='ativo' AND ativo='true' AND codigo<>" . $_GET['codigo'];
                                        $nome = "substituido_por";
                                        $itemPadrao = "$substituido";
                                        $itemZero = " ";
                                        $css = "form-control";
                                        $js = ($status!="Substituido")?"style='visibility:hidden'":"";
                                        echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css,$itemZero,$js);
                                        ?>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Detalhamento</label>
                                        <input type="hidden" id="cod_texto" name="detalhamento"/>
                                        <textarea readonly id="detalhamento" rows="6"
                                                  class="form-control"><?= $detalhamento ?></textarea>


                                        <div class="col-md-2">

                                        <br>
                                            <button type="button" class="btn btn-xs btn-primary"   data-toggle='modal' data-target='#modal_texto'>Alterar Detalhamento</button>
                                        </div>
                                    </div>

                                </div>
                                <br>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--/categorias-->

            <!--categorias-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Veículos compatíveis</div>
                    <div class="panel-body">
                        <table class="table table-striped data_table" id="table_veiculos">
                            <thead>
                            <th>Id</th>
                            <th>Fabricante</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Versão</th>
                            <th>Sistema</th>
                            <th><div class='btn-group btn-group-xs' role='group'><button type="button" class='btn btn-primary' id="add_veiculo" title='Adicionar veículo'><span class='glyphicon glyphicon-plus'></span></button></div></th>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "select a.codigo,b.nome fabricante, c.nome veiculo,
                                            if((a.anoini>0) and (a.acimade<=0),concat('De: ',a.anoini,' Até: ',a.anofim),
                                            if(a.acimade >0,concat('A partir de: ',a.acimade),'Todos'))ano,a.versao,a.sistema
                                            from  produto_veiculo a
                                            join fabricantes b on b.codigo=a.cod_fabricante
                                            join veiculos c on c.codigo=a.cod_veiculo
                                            where a.cod_produto=" . $_GET['codigo'];

                            $bd->query($sql);
                            $rs = $bd->getResult();
                            if (mysql_num_rows($rs) > 0) {
                                $out ="";
                                while ($row = mysql_fetch_assoc($rs)) {
                                    $out .="<tr>";
                                    foreach( $row as $td){
                                        $out .= "<td>$td</td>";
                                    }
                                    $out .= "<td><input type='hidden' id='veiculo_registrado_{$row['codigo']}' name='veiculo_registrado_{$row['codigo']}' value='{$row['codigo']}'><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-danger excluir_tr'  title='Excluir veículo'><span class='glyphicon glyphicon-minus'></span></bu></div></td>";
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
            <!--/categorias-->


            <!--vídeos-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Vídeos</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="input-group">
                                    <input type="url" class="form-control" placeholder="youtube.com" id="url_video" name="url_video">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" onclick="add_video()">Adicionar</button>
                                </span>
                                </div>
                                <!-- /input-group -->
                            </div>
                            <br>
                            <div class="row" id="videos">
                                <?php
                                $sql = "SELECT codigo,url FROM produto_midia WHERE tipo='video' AND deletado='false' AND cod_produto=".$_GET['codigo'];
                                $bd->query($sql);
                                $rs = $bd->getResult();
                                if (mysql_num_rows($rs) > 0) {
                                    $out = array();
                                    while ($row = mysql_fetch_assoc($rs)) {
                                        extract($row);
                                        $parts = parse_url($url);
                                        parse_str($parts['query'], $query);
                                        echo "<div class='alert alert-default alert-dismissible arquivo_video col-xs-12 col-sm-12 col-lg-offset-1 col-lg-4 panel panel-default center-block' role='alert' data-codigo='video_{$query['v']}'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><iframe width='300' height='200' src='https://www.youtube.com/embed/{$query['v']}' frameborder='0' allowfullscreen></iframe></li></div>";
                                        echo "<input type='hidden' value='{$url}' name='video_{$query['v']}' id='video_{$query['v']}'/>";
                                    };
                                };
                                ?>
                            </div>
                        </div>

                        <button type="button" class="btn btn-xs btn-primary"   data-toggle='modal' data-target='#modal_video'>Incluir Vídeo</button>
                    </div>
                </div>
            </div>
            <!--vídeos-->

            <!--Download Center-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Central de Downloads</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="input-group">
                                    <input type="file" name="arquivo_pdf[]" id="arquivos_pdf" multiple accept="application/pdf" class="form-control"/>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <?php
                                $sql = "SELECT codigo,url, titulo FROM produto_midia WHERE tipo='download' AND deletado='false' AND cod_produto=".$_GET['codigo'];
                                $bd->query($sql);
                                $rs = $bd->getResult();
                                if (mysql_num_rows($rs) > 0) {
                                    $out = array();
                                    while ($row = mysql_fetch_assoc($rs)) {
                                        echo "<div class='alert alert-warning alert-dismissible arquivo_pdf' role='alert' data-codigo=".$row['codigo']."><button type='button' class='close' data-dismiss='alert' aria-label='Close' ><span aria-hidden='true'>&times;</span></button><i class='fa fa-file-pdf-o fw'></i><a href='{$row['codigo']}' target='_blank'> {$row['titulo']}</a></div>";
                                    };
                                };
                                ?>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <!--Download Center-->


            <!--Dados Estatísticos-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">Dados Estatísticos</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <p>Último Clique: 02/05/2015 14:35</p>

                            </div>


                            <div class="col-md-2">
                                <p>Cliques Totais: 3858</p>
                            </div>

                            <div class="col-md-2">
                                <p>Últimos 6 meses: 825</p>
                            </div>


                            <div class="col-md-2">
                                <p>Últimos 30 Dias: 825</p>
                            </div>


                            <div class="col-md-2">

                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                         aria-valuemax="100" style="width: 60%;">
                                        Percentual de Cliques: 60%
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!--/Dados Estatísticos-->

            <!--Modal imagem-->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal_images">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Selecionar imagem</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <?php

                                $dir    = '../dist/img/produtos/';
                                $files = scandir($dir);
                                foreach($files as $file){
                                    if($file!="." && $file!=".." && $file != "Thumbs.db"){
                                        echo "<div class='col-xs-6 col-md-3'><a href='#' class='thumbnail thun_url' data-url='$dir$file'><img src='$dir$file'></a></div>";
                                    }
                                }

                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!--/Modal imagem-->



            <!--Modal texto-->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal_texto">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Selecionar Detalhamento</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class='col-xs-12 col-md-12'>

                                <?php




                                $sql = "SELECT id,descricao,nome  from texto WHERE ativo='true'";
                                $bd->query($sql);
                                $rs = $bd->getResult();
                                if (mysql_num_rows($rs) > 0) {
                                    $out = array();
                                    while ($row = mysql_fetch_assoc($rs)) {

                                        $lista_familia="";

                                        $sql2 = "SELECT codigo cod_familia,nome FROM familia WHERE ativo='true'";
                                        $bd->query($sql2);
                                        $rs2 = $bd->getResult();
                                        if (mysql_num_rows($rs2) > 0) {
                                            while ($row2 = mysql_fetch_assoc($rs2)) {
                                                $lista_familia.="<li id='{$row2['cod_familia']}' data-op='1' data-cod_texto={$row['id']} data-cod_pro='{$_GET['codigo']}'><a>Família". " "."{$row2['nome']}</a></li>";
                                            };
                                        };



                                        echo "<div class='row' >
                                          <div class='col-xs-12 col-md-12'>
                                            <a style='text-decoration: none' class='thumbnail'>
                                              <strong> {$row['nome']}:</strong>
                                              {$row['descricao']}</a>
                                              <div class='btn-group'>
                                                <button class='btn btn-primary btn-xs dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                 <i class='fa fa-cog '></i> Aplicar <span class='caret'></span>
                                                </button>
                                              <ul class='dropdown-menu' id='myid' data-cod_produto='{$row['nome']}'>
                                                 <li data-op='0' data-cod_texto={$row['id']} data-cod_pro='{$_GET['codigo']}'>  <a> Apenas neste produto: $nome_produto</a></li>
                                                 <li role='separator' class='divider'></li>";
                                                 echo " $lista_familia
                                              </ul>
                                            </div><br><hr>
                                            </div>
                                        </div>";
                                    };
                                };

                                ?>

                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!--/Modal texto-->




            <!--Modal videos-->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal_video">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Galeria de Vídeos</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class='col-xs-12 col-md-12'>

                                    <?php

                                    $sql = "SELECT id,descricao,nome  from texto WHERE ativo='true'";
                                    $bd->query($sql);
                                    $rs = $bd->getResult();
                                    if (mysql_num_rows($rs) > 0) {
                                        $out = array();
                                        while ($row = mysql_fetch_assoc($rs)) {

                                            $lista_familia="";

                                            $sql2 = "SELECT codigo cod_familia,nome FROM familia WHERE ativo='true'";
                                            $bd->query($sql2);
                                            $rs2 = $bd->getResult();
                                            if (mysql_num_rows($rs2) > 0) {
                                                while ($row2 = mysql_fetch_assoc($rs2)) {
                                                    $lista_familia.="<li id='{$row2['cod_familia']}' data-op='1' data-cod_texto={$row['id']} data-cod_pro='{$_GET['codigo']}'><a>Família". " "."{$row2['nome']}</a></li>";
                                                };
                                            };



                                            echo "<div class='row' >
                                          <div class='col-xs-12 col-md-12'>
                                            <a style='text-decoration: none' class='thumbnail'>



                                 <div class='row' id='videos'>";

                                $sql = "SELECT codigo,url FROM produto_midia WHERE tipo='video' AND deletado='false' AND cod_produto=".$_GET['codigo'];
                                $bd->query($sql);
                                $rs = $bd->getResult();
                                if (mysql_num_rows($rs) > 0) {
                                    $out = array();
                                    while ($row = mysql_fetch_assoc($rs)) {
                                        extract($row);
                                        $parts = parse_url($url);
                                        parse_str($parts['query'], $query);
                                        echo "<div class='alert alert-default alert-dismissible arquivo_video col-xs-12 col-sm-12 col-lg-offset-1 col-lg-4 panel panel-default center-block' role='alert' data-codigo='video_{$query['v']}'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><iframe width='300' height='200' src='https://www.youtube.com/embed/{$query['v']}' frameborder='0' allowfullscreen></iframe></li></div>";
                                        echo "<input type='hidden' value='{$url}' name='video_{$query['v']}' id='video_{$query['v']}'/>";
                                    };
                                };

                               echo "</div>



                                              <div class='btn-group'>
                                                <button class='btn btn-primary btn-xs dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                 <i class='fa fa-cog '></i> Aplicar <span class='caret'></span>
                                                </button>
                                              <ul class='dropdown-menu' id='myid' data-cod_produto='{$row['nome']}'>
                                                 <li data-op='0' data-cod_texto={$row['id']} data-cod_pro='{$_GET['codigo']}'>  <a> Apenas neste produto: $nome_produto</a></li>
                                                 <li role='separator' class='divider'></li>";
                                            echo " $lista_familia
                                              </ul>
                                            </div><br><hr>
                                            </div>
                                        </div>";
                                        };
                                    };

                                    ?>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!--/Modal videos-->





            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-lg btn-primary pull-right">Salvar</button>
                    <button type="button" class="btn btn-xs btn-danger" onclick="excluir_produto(<?= $_GET['codigo']?>)">Excluir</button>
                </div>
            </div>
            <br>
            <br>
            <br>
        </form>
    </div>
<!-- /#page-wrapper -->
</div>

<!-- /#wrapper -->

<!--Modal Veiculos-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal_veiculos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar veículo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Fabricante</label>
                        <?php
                        $sql = "SELECT codigo,nome FROM fabricantes";
                        echo $bd->SetComboSelect($sql,'slt_fabricante','','form-control'," ","onchange='slt_fabricante()' required");
                        ?>
                    </div>
                    <div class="col-md-4">
                        <label for="">Modelo</label>
                        <div id="div_veiculos">
                        <?php
                        $sql = "SELECT codigo,nome FROM veiculos";
                        echo $bd->SetComboSelect($sql,'slt_modelo','','form-control'," ","disabled required");
                        ?>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="">Versão</label>
                        <input type="text" class="form-control" id="ipt_versao">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Ano inicial</label>
                        <input type="number" class="form-control" id="ipt_inicial" value="" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="">Ano final</label>
                        <input type="number" class="form-control" id="ipt_final" value="" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="">A partir de</label>
                        <input type="number" class="form-control" id="ipt_acima" value="" min="0">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Sistema</label>
                        <input type="text" class="form-control" id="ipt_sistema">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="add_veiculo()">Adicionar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--/Modal Veiculos-->

<div id="modalLoading" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"></div>

<?php
include_once "scripts.php";
?>

</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

</script>

</html>
