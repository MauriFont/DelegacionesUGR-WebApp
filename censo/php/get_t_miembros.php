<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

$sql = "SELECT id, CONCAT(apellidos, ', ', nombre) as completo FROM Miembros WHERE DATE(salida) = '0000-00-00' ORDER BY apellidos";
$m = $pdo->getUnique($sql);

echo json_encode($m);

?>