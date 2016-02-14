<?php
if(isset($_POST)) {
    foreach (array_keys($_POST) as $key) {
        $_POST[$key] = trim($_POST[$key]);
        $_POST[$key] = stripslashes($_POST[$key]);
        $_POST[$key] = htmlspecialchars($_POST[$key]);
    }
}
if(isset($_GET)) {
    foreach (array_keys($_GET) as $key) {
        $_GET[$key] = trim($_GET[$key]);
        $_GET[$key] = stripslashes($_GET[$key]);
        $_GET[$key] = htmlspecialchars($_GET[$key]);
    }
}
