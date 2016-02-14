<?php
require_once "../backend/first_all.php";

$bd = new BD();

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
            <br>
            <!--categorias-->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Produtos
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-striped data_table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <th>id</th>
                                <th>Produto</th>
                                <th>Linha</th>
                                <?php
                                    $sql = "SELECT descricao FROM aplicacao where ativo='true' order by codigo";
                                    $bd->query($sql);
                                    echo $bd->getResult('th');

                                    $sql = "SELECT codigo, descricao FROM aplicacao where ativo='true' order by codigo";
                                    $bd->query($sql);
                                    $my_array = $bd->getResult('array');
                                ?>
                                <th>Fios</th>
                                <th>Desconto</th>
                                <th>Status</th>
                                <th><div class='btn-group btn-group-xs' role='group'><a href='detalhe_produto.php?codigo=0' class='btn btn-primary'  title='Adicionar produto'><span class='glyphicon glyphicon-plus'></span></a></div></th>
                            </thead>
                            <tbody>

                                <?php
                                    $campos="";
                                    for($i=0;$i<count($my_array);$i++) {
                                        $campos .= ", if( (SELECT count(*) FROM produto_aplicacao c join aplicacao d on d.codigo=c.cod_aplicacao    WHERE d.ativo='true' and c.cod_aplicacao = ".$my_array[$i]['codigo']." and c.cod_produto=a.codigo)>0,'true','') campo_$i ";
                                    }
                                    $sql = "SELECT a.codigo,a.nome_produto , b.descricao linha $campos,a.fios,a.desconto, a.status,a.status FROM produtos a JOIN linhas b ON b.codigo=a.cod_linha WHERE ativo='true'";

                                    $bd->query($sql);
                                    $resposta =  $bd->getResult();
                                    if (mysql_num_rows($resposta) > 0) {
                                        $out = "";
                                        while ($row = mysql_fetch_row($resposta)) {
                                            $out .= "<tr>";

                                            for( $i=0; $i<count($row);$i++){

                                                $td = $row[$i];

                                                if($td == 'true'){
                                                    $td="<i class='fa fa-check ' style='color: green'></i>";
                                                }

                                                if($i+1==count($row)){
                                                    $td= "<div class='btn-group btn-group-xs' role='group'><a href='detalhe_produto.php?codigo=$row[0]' class='btn btn-info'  title='Informações do produto'><span class='glyphicon glyphicon-info-sign'></span></a></div>";
                                                }

                                                $out .= "<td>".$td."</td>";
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
            <!--/categorias-->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->



<?php
    include_once "scripts.php";
?>

</body>
</html>
