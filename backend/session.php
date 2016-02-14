<?php
class Session {

    public $session_out = "login.php";

    public function start_session($user,$password){

        if (!class_exists('BD')){
            echo "Não há conexão com o banco de dados";
            exit;
        };
        $bd = new BD();
        $sql = "SELECT codigo, email, admin FROM usuarios WHERE email='$user' AND senha='$password' AND ativo=true";
        $bd->query($sql);
        if($bd->getLinha()){
            if(session_id() == '' || !isset($_SESSION)) {
                session_start();
                $rs = $bd->getResult('array');
                $codigo = $rs[0]['codigo'];
                $admin = $rs[0]['admin'];
            }
            $_SESSION['email'] = $user;
            $_SESSION['codigo'] = $codigo;
            $_SESSION['admin'] = $admin;

            $bd->record_log("log_login",'login');

            //error_reporting(E_ALL);
            header('Location:index.php');
            //exit;
        }
    }

    public function destroy_session(){
        if(session_id() == '' || !isset($_SESSION)) {
            session_start();
        }

        $bd = new BD();
        $bd->record_log("log_login",'logout');

        session_destroy();
        header('Location:' . $this->session_out);
        exit;
    }

    public function check_session(){
        if(session_id() == '' || !isset($_SESSION)) {
            session_start();
        }
        if(!isset($_SESSION['email'])){
            header('Location:'.$this->session_out);
            exit;
        }
    }
}