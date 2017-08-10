<?php
session_start();
ob_start();
require_once ("../classes/class.user.php");
require_once ("../classes/class.bd.php");

$use_user = $_POST["use_user"];
$use_password = $_POST["use_password"];

$sql = "SELECT * FROM User INNER JOIN PrepCentre on User.prc_id=PrepCentre.prc_id WHERE use_user='{$use_user}' and use_password ='{$use_password}'";

$bd = new BD();
$resultados = $bd->ejecutar($sql);
$r = $bd->retornar_fila($resultados);

if (is_numeric($r["use_id"])) { 
    $_SESSION["use_id"] = $r["use_id"];
    $_SESSION["use_name"] = $r["use_name"];
    $_SESSION["use_lastname"] = $r["use_lastname"];
    $_SESSION["use_usertype"] = $r["use_usertype"];
    $_SESSION["prc_id"] = $r["prc_id"];
    $_SESSION["prc_name"] = $r["prc_name"];
    $url = "exam_menu.php";
} else {
    $nombre = $_POST["usuario"];
    unset($_SESSION["use_id"], $_SESSION["use_name"], 
        $_SESSION["use_lastname"], $_SESSION["use_usertype"], 
        $_SESSION["prc_id"], $_SESSION["prc_name"]); // esto borra lo que tiene "idusuario y nombre" de SESSION, es decir borro la sesi�n
    $url = "login_form.php?error=1&nombre=" . $nombre;
}

header("Location: {$url}");
ob_end_flush();
?>