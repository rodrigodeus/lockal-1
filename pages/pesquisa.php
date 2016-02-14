<?php
require_once "../backend/first_all.php";

$bd = new BD();

if (!isset($_GET['fabricante'])) {

    $palavra_nula = array("da", "de", "di", "do", "du", "para", "a", "com", 'ao', 'a', 'e', 'i', 'o', 'u', 'até');

    $busca_dividida = explode(' ', $_GET["pesquisa"]);
    $quant = count($busca_dividida);
    for ($i = 0; $i < $quant; $i++) {

        $pesquisa = strtolower($busca_dividida[$i]);

        $ano_encontrado = array();

        if (is_numeric($pesquisa) && ($pesquisa > 1900) && ($pesquisa < 2200)) {
            // faz criterio de anos
            $ano_encontrado[] = $pesquisa;

        }

        if (in_array($pesquisa, $palavra_nula) == false) {
            if ($i == 0) {
                $criterio1 .= "(a.nome like '%" . $pesquisa . "%') ";
            } else {
                $criterio1 .= " and (a.nome like '%" . $pesquisa . "%') ";
            }
        }
    }
    $criterio1 .= "";


    for ($i = 0; $i < $quant; $i++) {
        $pesquisa = strtolower($busca_dividida[$i]);
        if (in_array($pesquisa, $palavra_nula) == false) {
            if ($i == 0) {
                $criterio2 .= " a.nome like '%" . $pesquisa . "%' ";

            } else {
                $criterio2 .= " or  a.nome like '%" . $pesquisa . "%'  ";
            }
        }
    }
    $criterio2 .= " ";

    for ($i = 0; $i < $quant; $i++) {
        $pesquisa = strtolower($busca_dividida[$i]);
        if (in_array($pesquisa, $palavra_nula) == false) {
            if ($i == 0) {
                $criterio3 .= "nome_produto like '%" . $pesquisa . "%' ";
            } else {
                $criterio3 .= " and nome_produto like '%" . $pesquisa . "%' ";
            }
        }
    }
    $criterio3 .= " ";


    for ($i = 0; $i < $quant; $i++) {
        $pesquisa = strtolower($busca_dividida[$i]);
        if (in_array($pesquisa, $palavra_nula) == false) {
            if ($i == 0) {
                $criterio4 .= "detalhamento like '%" . $pesquisa . "%' ";
            } else {
                $criterio4 .= " or detalhamento like '%" . $pesquisa . "%' ";
            }
        }
    }
    $criterio4 .= " ";


    for ($i = 0; $i < $quant; $i++) {

        $pesquisa = strtolower($busca_dividida[$i]);
        if (in_array($pesquisa, $palavra_nula) == false) {
            if ($i == 0) {
                $criterio5 .= " nome_produto like '%" . $pesquisa . "%' ";
            } else {
                $criterio5 .= "or nome_produto  like '%" . $pesquisa . "%' ";
            }
        }
    }
    $criterio5 .= "";


    for ($i = 0; $i < $quant; $i++) {
        $pesquisa = strtolower($busca_dividida[$i]);
        if (in_array($pesquisa, $palavra_nula) == false) {
            if ($i == 0) {
                $criterio6 .= " f.nome like '%" . $pesquisa . "%' ";

            } else {
                $criterio6 .= " or  f.nome like '%" . $pesquisa . "%'  ";
            }
        }
    }
    $criterio6 .= " ";


    $sql = "select c.codigo,c.nome_produto,b.cod_veiculo,a.nome
from veiculos a
join produto_veiculo b on b.cod_veiculo=a.codigo
join produtos c on c.codigo=b.cod_produto
left join fabricantes f on f.codigo=b.cod_fabricante
where (" . $criterio1 . ") or ( " . $criterio2 . ") or ( " . $criterio6 . ")

union all
select codigo,nome_produto,
0 cod_veiculo, '' nome_veiculo from produtos where   ( " . $criterio3 . ") or (" . $criterio4 . ")
or
 ( " . $criterio5 . ")";


    $bd->query($sql);
    $resposta = $bd->getResult("array");
    extract($resposta[0]);

} else {

    $dados = $_GET;
    foreach ($dados as $key=>$value){
        $dados[$key] = ( $dados[$key]==0)?">0":"={$dados[$key]}";
        if($key=='versao'){

            if($_GET[$key]=="Todos"){
                $dados[$key]="<>''";
            }else{
                $dados[$key]="='".$_GET[$key]."'";
            }
        }
    }

    $sql = "select c.codigo, c.nome_produto,b.cod_veiculo,a.nome
            from veiculos a
            join produto_veiculo b on b.cod_veiculo=a.codigo
            join produtos c on c.codigo=b.cod_produto
            join fabricantes d on d.codigo=b.cod_fabricante
            join produto_aplicacao e on e.cod_produto=c.codigo

            where a.codigo{$dados['veiculo']}
            and
            d.codigo{$dados['fabricante']}
            and
            ( ( b.anoini >={$_GET['anoini']} and b.anofim<={$_GET['anofin']}) or (  b.acimade>0 and ({$_GET['anoini']}>=b.acimade or {$_GET['anofin']}>=b.acimade) ) )
            and
            c.cod_linha{$dados['linha']}
            and b.versao {$dados['versao']}
            group by a.codigo";




    $bd->query($sql);
    $resposta = $bd->getResult("array");
    extract($resposta[0]);
    $_GET["numpg"]=8;
    $_GET['pesquisa']="geral";

};

?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php
include_once "head.php";
include "functions.php";
include "scripts.php";
?>

<body>

<div id="wrapper">
    <?php
    include_once "nav.php";
    ?>
    <div id="page-wrapper">
        <br>
        <!--palavra chave-->
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">

                    <div class="row">

                        <div class="col-md-10">

                            Pesquisar por palavra chave
                        </div>


                        <div class="col-md-1">


                            <select id='regpag' name='regpag' class='form-control' onchange='pesquisa()'>

                                <option value='8'<?php if ($_GET["numpg"] == 8) {
                                    echo "selected";
                                }; ?> title='exibir'>8
                                </option>
                                <option value='12'<?php if ($_GET["numpg"] == 12) {
                                    echo "selected";
                                }; ?>>12
                                </option>
                                <option value='16'<?php if ($_GET["numpg"] == 16) {
                                    echo "selected";
                                }; ?>>16
                                </option>
                                <option value='20'<?php if ($_GET["numpg"] == 20) {
                                    echo "selected";
                                }; ?>>20
                                </option>
                                <option value='<?= $regitros ?>'><?= $regitros ?></option>
                            </select>

                        </div>

                        <div class="col-md-1">

                            registros
                        </div>

                    </div>


                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="pesquisa" id="pesquisa" class="form-control"
                                       onkeypress="enter()"
                                       value="<?= $_GET['pesquisa'] ?>"
                                       placeholder="Digite uma palavra chave" autofocus>
                                         <span class="input-group-btn">
                                            <button class="btn btn-primary" id="busca" name="busca"
                                                    type="button" onclick="pesquisa()"><i
                                                    class="fa fa-search fa-fw"></i>Pesquisar
                                            </button>
                                         </span>
                            </div>
                            <!-- /input-group -->

                        </div>
                    </div>


                </div>

            </div>

        </div>
        <!--fim palavra chave-->

        <!--criterios-->
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Pesquisa por critérios</div>
                <div class="panel-body">
                    <form action="pesquisa.php" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Fabricante</label>
                                <?php
                                $consulta = "select 0 codigo,'Todos'  fabricante union all select codigo,nome fabricante from fabricantes";

                                $nome = "fabricante";
                                $itemPadrao = 0;
                                $css = "form-control";
                                echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                ?>
                            </div>

                            <div class="col-md-5">
                                <label for="">Veículo</label>
                                <?php
                                $consulta = "select 0 codigo,'Todos'  veiculo union all select codigo,nome veiculo from veiculos";

                                $nome = "veiculo";
                                $itemPadrao = 0;
                                $css = "form-control";
                                echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                ?>
                            </div>

                            <div class="col-md-2">

                                <label for=""> Ano Inicial</label>
                                <input type="number" class="form-control" id="anoini" value="<?= date('Y') ?>" name="anoini" min="0" required>

                            </div>

                            <div class="col-md-2">
                                <label for="">Ano Final</label>
                                <input type="number" class="form-control" id="anofin" value="<?= date('Y') ?>" name="anofin" min="0" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Versão</label>
                                <?php
                                $consulta = "select 'Todos' codigo,'Todos'  linha union all select versao, versao from produto_veiculo WHERE versao<>'-' AND versao<>' ' GROUP BY versao";

                                $nome = "versao";
                                $itemPadrao = "";
                                $css = "form-control";
                                echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                ?>
                            </div>


                            <div class="col-md-2">
                                <label for="">Linha de Produto</label>
                                <?php
                                $consulta = "select 0 codigo,'Todos'  linha union all select codigo,descricao fabricante from linhas";

                                $nome = "linha";
                                $itemPadrao = 0;
                                $css = "form-control";
                                echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                ?>
                            </div>


                            <div class="col-md-4">
                                <label for="">Aplicação</label>
                                <?php
                                $consulta = "select 0 codigo,'Todos'  categoria union all select codigo,descricao categoria from aplicacao";
                                $nome = "aplicacao";
                                $itemPadrao = 0;
                                $css = "form-control";
                                echo $bd->SetComboSelect($consulta, $nome, $itemPadrao, $css);
                                ?>
                            </div>
                            <div class="col-md-2">
                                <label for="" style="color: transparent">.</label><br>
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-search fa-fw"></i>Pesquisar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <?php

            $regitros = 0;
            if ($_GET['pesquisa'] <> "") {
            $_atual = (((int)$_GET["pg"] - 1) > 0) ? ((int)$_GET["pg"] - 1) : 1;
            $urlatual = "pesquisa.php?pesquisa=" . $_GET["pesquisa"] . "&pg=" . $_atual . "&numpg=";
            $consulta = $sql;
            $bd->query($consulta);
            $regitros = $bd->getNumLinha();


            echo "<div id='result' Resultado para: " . $_GET["pesquisa"] . "</div>";

            ?>
        </div>
        <div class="row">
            <div class="col-md-12" id="erro">
            </div>
        </div>

        <div class='row' id="corpo">

            <?php
            $limite = $_GET["numpg"];
            $sqlresultado = ceil($regitros / $limite);
            $pg = (isset($_GET["pg"])) ? (int)$_GET["pg"] : 1;
            $start = ($pg - 1) * $limite;
            $consulta = $sql . " limit $start,$limite ";
            $bd->query($consulta);
            $rs = $bd->getResult();

            if (mysql_num_rows($rs) > 0) {
                while ($row = mysql_fetch_assoc($rs)) {
                    echo "     <div class='col-sm-6 col-md-3'>
                                                    <div class='thumbnail'>
                                                           <img src='../dist/img/produtos/cs_AC01.jpg' alt='' width='250px'>
                                                           <h3><span>" .
                        $row['nome_produto'] . "</span></h3>
                                                           <hr>
                                                           <p><strong> Linha:</strong> " . $row['linha'] . "</p>

                                                           <p><a href='detalhe_produto.php?codigo=" . $row['codigo'] . "' class='btn-sm btn-primary' role='button'>Detalhes</a>
                                                   </div>
                                                </div>";
                }
            }

            ?>

        </div>
        <div class="row">
            <?php


            if ($regitros > 0) {


                echo "<div class='center-block col-md-12' id='paginacao'>";
                $_atual = (((int)$_GET["pg"] - 1) > 0) ? ((int)$_GET["pg"] - 1) : 1;
                if(isset($_GET['fabricante'])){
                    $pg_ant = "pesquisa.php?pesquisa=" . $_GET["pesquisa"] . "&pg=" . $_atual . "&numpg=" . $_GET["numpg"]."&fabricante=" . $_GET["fabricante"]."&veiculo=" . $_GET["veiculo"]."&anoini=" . $_GET["anoini"]."&anofin=" . $_GET["anofin"]."&versao=" . $_GET["versao"]."&linha=" . $_GET["linha"]."&aplicacao=" . $_GET["aplicacao"];
                }else{
                    $pg_ant = "pesquisa.php?pesquisa=" . $_GET["pesquisa"] . "&pg=" . $_atual . "&numpg=" . $_GET["numpg"];
                }

                if (((int)$_GET["pg"] - 1) > 0) {
                    echo "<ul class='pagination center-block col-md-12' >
                                    <li class=''><a href='" . $pg_ant . "' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                } else {
                    echo "<ul class='pagination center-block col-md-12' >
                                      <li class='disabled'><a href='' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                }
                $contpg = 1;
                while ($contpg <= $sqlresultado) {
                    if(isset($_GET['fabricante'])){
                        $url2 = "pesquisa.php?pesquisa=" . $_GET["pesquisa"] . "&pg=" . $contpg . "&numpg=" . $_GET["numpg"]."&fabricante=" . $_GET["fabricante"]."&veiculo=" . $_GET["veiculo"]."&anoini=" . $_GET["anoini"]."&anofin=" . $_GET["anofin"]."&versao=" . $_GET["versao"]."&linha=" . $_GET["linha"]."&aplicacao=" . $_GET["aplicacao"];;
                    }else{
                        $url2 = "pesquisa.php?pesquisa=" . $_GET["pesquisa"] . "&pg=" . $contpg . "&numpg=" . $_GET["numpg"];
                    }
                        $classe = ($contpg == $_GET["pg"]) ? "active" : "";
                    echo "<li class=$classe><a href='$url2'>$contpg <span class='sr-only'>(current)</span></a></li>";
                    $contpg++;
                }
                echo "<li class=''><a href='" . "pesquisa.php?pesquisa=" . $_GET["pesquisa"] . "&pg=" . $sqlresultado . "&numpg=" . $_GET["numpg"] . " ' aria-label=''><span aria-hidden='true'>»</span></a></li><ul> </div>";


            } else {

                echo "<div class='center-block col-md-12' id='divmsg'>
                         <div class='alert alert-danger center-block col-md-12'>Sua busca não retornou resultados</div></div>";

            }
            echo "</div>";

            }


            ?>

        </div>
    </div>


</body>

</html>
