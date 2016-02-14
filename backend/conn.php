<?php 
class BD
{
    private $bdCon = NULL;
    private $totalRows = "0";
    private $sql = NULL;
    private $insert_id = "0";

    public function __construct()
    {
        $localhost = "lab212.com.br";
        $my_user = "lab212co_local";
        $my_password="ritris123";
        $my_db= "lab212co_local";

        $this->bdCon = @mysql_connect($localhost, $my_user,$my_password) or die("BD->Conectar(Nao foi possivel conectar ao banco: Erro:" . mysql_error() . ")");
        @mysql_select_db($my_db, $this->bdCon) or die("BD->Conectar(Banco de dados inexistente. " . mysql_error() . ")");
        $this->forceUTF8();
    }

    public function forceUTF8(){
        mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    }

    public function get($dado){
        return $this -> $dado;
    }

    public function set($dado, $valor){
        $this -> $dado = $valor;
    }

    public function fecharConexao(){
        mysql_close($this->bdCon);
    }

    private function insert_id() {
        $this->insert_id = mysql_insert_id();
    }

    public function query($sql,$print=false){ /*Se $print = true mostra a sql na pagina*/
        if(!empty($sql)){
            $forbidden  = array('truncate','TRUNCATE','drop','DROP','<script','<SCRIPT','<iframe','<iframe','$');
            $replace    = array('','','','',htmlentities('<script'),htmlentities('<SCRIPT'),htmlentities('<iframe'),htmlentities('<iframe'),'&#36;');

            $safeSQL = trim(str_replace($forbidden,$replace,$sql));
            $this->sql = $safeSQL;
            if($print==true) echo $this->sql."<br>";
        }
        else return false;
    }

    public function insert($table, $dadosInput){
        if(is_array($dadosInput) && !empty($table))
        {
            $campos	=	""; $valores=	"'"; $status = false;
            foreach($dadosInput as $setCampos=>$setValores){
                $campos		.=	$setCampos.",";
                $valores	.=	$setValores."','";
            }
            $campos = substr($campos, 0, -1);
            $valores = substr($valores, 0, -2);

            $this->query("INSERT INTO $table ($campos) VALUES ($valores)");
            $status = mysql_query($this->sql) or die("Erro ao inserir dados: ".mysql_error());
            if($status==true) $this->insert_id();
            return $status;
        }else return false;
    }

    public function update($table, $dadosInput, $where){
        if(is_array($dadosInput) || !empty($table))
        {
            $campos =	"";
            foreach($dadosInput as $setCampos=>$setValores){
                $campos		.=	$setCampos." = ".$setValores.",";
            }
            $campos = substr($campos, 0, -1);
            $this->query("UPDATE $table SET $campos WHERE $where");
            $status = @mysql_query($this->sql) or die("Erro ao atualizar dados: ".mysql_error());
            return $status;
        }else return false;
    }

    public function delete($table, $where){
        if(!empty($table) || !empty($where))
            return @mysql_query("DELETE FROM $table WHERE $where") or die("Erro ao deletar dados: ".mysql_error());
        else return false;
    }

    public function call_SQL_function($func, $dados){
        if(!empty($func) || !empty($dados)){
            $executar	=	@mysql_query("SELECT $func ($dados)") or die("Erro: ".mysql_error());
            return $executar;
        }else
            return false;
    }

    public function call_SQL_procedure($procedure, $dados){
        if(!empty($procedure) || !empty($dados)){
            $executar	=	@mysql_query("CALL $procedure ($dados)") or die("Erro: ".mysql_error());
            return $executar;
        }else
            return false;
    }

    public function getResult($type=null){

        $consulta = $this->sql;
        if(!$consulta) return false;
        else{
            $rs = @mysql_query($consulta) or die("Erro: ($consulta) - " . mysql_error() );
            if( $rs && ( mysql_num_rows($rs) == 0 ) ){
                $this->totalRows = "0";
                return false;
            }
            else{
                $this->totalRows = mysql_num_rows($rs);

                switch ($type) {
                    case "json":
                        if (mysql_num_rows($rs) > 0) {
                            $out = array();
                            while ($row = mysql_fetch_assoc($rs)) {
                                $out[] = $row;
                            };
                            return json_encode($out);
                        };
                        break;
                    case "array":
                        if (mysql_num_rows($rs) > 0) {
                            $out = array();
                            while ($row = mysql_fetch_assoc($rs)) {
                                $out[] = $row;
                            };
                            return $out;
                        };
                        break;
                    case "row":
                        if (mysql_num_rows($rs) > 0) {
                            $out = "";
                            while ($row = mysql_fetch_row($rs)) {
                                $out .= "<tr>";
                                foreach( $row as $td){
                                    $out .= "<td>$td</td>";
                                }
                                $out .= "</tr>";
                            };
                            return $out;
                        };
                        break;
                    case "th":
                        if (mysql_num_rows($rs) > 0) {
                            $out = "";
                            while ($row = mysql_fetch_row($rs)) {
                                foreach( $row as $th){
                                    $out .= "<th>$th</th>";
                                }
                            };
                            return $out;
                        };
                        break;
                    case "td":
                        if (mysql_num_rows($rs) > 0) {
                            $out = "";
                            while ($row = mysql_fetch_row($rs)) {
                                foreach( $row as $td){
                                    $out .= "<td>$td</td>";
                                }
                            };
                            return $out;
                        };
                        break;
                    default:


                    case "str":
                        if (mysql_num_rows($rs) > 0) {
                            $out = "";
                            while ($row = mysql_fetch_row($rs)) {
                                foreach( $row as $td){
                                    $out .= " $td ";
                                }
                            };
                            return $out;
                        };
                        break;
                    default:
                       return $rs;
                }

            }
        }
    }

    public function getLinha(){
        $consulta = $this->sql;
        if(!$consulta) return false;
        else{
            $rs = @mysql_query($consulta) or die("Erro: ($consulta) - " . mysql_error() );

            if( $rs && ( mysql_num_rows($rs) > 0 ) )
            {
                $linha = mysql_fetch_row($rs);
                mysql_free_result($rs);
                $this->totalRows = mysql_num_rows($rs);
                return $linha;
            }else{
                $this->totalRows = "0";
            }
        }
    }

    public function getNumLinha(){
        $consulta = $this->sql;
        if(!$consulta) return false;
        else{
            $rs = @mysql_query($consulta) or die("Erro: ($consulta) - " . mysql_error() );

            if( $rs && ( mysql_num_rows($rs) > 0 ) )
            {
                return mysql_num_rows($rs);
            }else{
                return 0;
            }
        }
    }

    public function getInt($seNulo){
        $consulta = $this->sql;
        if(!$consulta) return $seNulo;

        $rs = @mysql_query($consulta) or die("BD->GetInt($consulta) " . mysql_error() );

        if( $rs && ( mysql_num_rows($rs) > 0 ) )
        {
            $linha = mysql_fetch_row($rs);
            mysql_free_result($rs);

            if( is_numeric($linha[0]) )
                return $linha[0];
        }

        return $seNulo;
    }

    public function getStr($seNulo){
        $consulta = $this->sql;
        if(!$consulta) return $seNulo;

        $rs = mysql_query($consulta) or die("BD->GetStr($consulta) " . mysql_error() );
        if( $rs && ( mysql_num_rows($rs) > 0 ) )
        {
            $linha = mysql_fetch_row($rs);
            mysql_free_result($rs);

            if( $linha[0] != null )
                return $linha[0];
        }

        return $seNulo;
    }

    /******************************************************************************
    BD->SetComboSelect(): Retorna um elemento <SELECT> povoado com itens do BancoDeDados.
    $consulta:      Consulta SQL;
    $nome:          Nome do elemento resultante;
    $itemPadrao:    Se diferente de nulo, eh a opcao pre-selecionada
    $w:             Comprimento em pixels do elemento resultante.
    $itemZero:      Item a ser inserido no topo da lista. O atributo 'value' do $itemZero eh sempre 0 (zero).
    $js:            Evento JavaScript para embarcar no select.
     ******************************************************************************/
    function SetComboSelect( $consulta, $nome, $itemPadrao, $css = NULL, $itemZero = NULL, $js = NULL)
    {
        $cssClass = ( !is_numeric($css) ? "class=\"$css\"" : NULL );
        $elemento = "
				<select id=\"$nome\" name=\"$nome\" $cssClass $js>";
        $itens = "";
        $linha = NULL;
        $rs = @mysql_query($consulta) or die("BD->SetComboSelect($consulta) " . mysql_error() );

        if( $itemZero ){
            if( $itemPadrao == 0 )
                $itens = "
						<option value='0' title='".htmlentities(stripslashes($itemZero))."' selected='selected' >".htmlentities(stripslashes($itemZero))."</option>";
            else
                $itens = "
						<option value='0' title='".htmlentities(stripslashes($itemZero))."' >".htmlentities(stripslashes($itemZero))."</option>";
        }

        while( $linha = mysql_fetch_row($rs) ){

            if( $linha[0] != $itemPadrao )
                $itens .= "
						<option value='$linha[0]' title='".htmlentities(stripslashes($linha[1]))."'  >".htmlentities(stripslashes($linha[1]))."</option>";
            else
                $itens .= "
						<option value='$linha[0]' title='".htmlentities(stripslashes($linha[1]))."' selected='selected'>".htmlentities(stripslashes($linha[1]))."</option>";
        }

        mysql_free_result($rs);
        $elemento .= $itens . "
				</select>
				\n";

        return $elemento;
    }

    public function start_transaction(){
        $sql = "START TRANSACTION";
        $this->query($sql);
        $this->getResult();

    }

    public function commit(){
        $sql = "COMMIT";
        $this->query($sql);
        $this->getResult();
    }

    public  function record_log($table,$acao,$vinculo=null){
        $dados['cod_usuario'] = $_SESSION['codigo'];
        $dados['ip'] = $_SERVER['REMOTE_ADDR'];
        $dados['acao'] = $acao;
        $dados['vinculo'] = $vinculo;
        $this->insert($table,$dados);
    }

}