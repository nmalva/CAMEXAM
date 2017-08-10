<?php
session_start();
ob_start();
require_once ("../classes/class.user.php");
require_once ("../classes/class.bd.php");

$can_dni = $_POST["can_dni"];

$sql = "SELECT * FROM Candidate WHERE can_dni='{$can_dni}' ORDER BY can_id DESC";


$bd = new BD();
$resultados = $bd->ejecutar($sql);
$r = $bd->retornar_fila($resultados);


if (is_numeric($r["can_id"])) { 
    $_SESSION["can_id"] = $r["can_id"];
    $_SESSION["can_firstname"] = $r["can_firstname"];
    $_SESSION["can_lastname"] = $r["can_lastname"];
    $url = "exam_info.php";
} else {
    unset($_SESSION["can_id"], $_SESSION["can_name"], 
        $_SESSION["can_lastname"], $_SESSION["can_dni"]); 
    $url = "login_form_info.php?error=1";
}

header("Location: {$url}");
ob_end_flush();
?>