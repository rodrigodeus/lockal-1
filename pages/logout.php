<?php
require_once "../backend/conn.php";
require_once "../backend/session.php";
include_once "../backend/injection_form.php";

$session = new Session();
$session->destroy_session();




