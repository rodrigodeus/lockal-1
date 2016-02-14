<?php
/**
 * Created by PhpStorm.
 * User: rodrigo.martins
 * Date: 15/01/2016
 * Time: 14:06
 */

require_once "../backend/conn.php";
require_once "../backend/session.php";
include_once "../backend/injection_form.php";

$session = new Session();
$session->check_session();