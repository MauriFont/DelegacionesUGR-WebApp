<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

$sql = "SELECT max(orden) FROM Areas";
$max_orden = $pdo->get($sql)->fetch(PDO::FETCH_NUM)[0]+1;

$sql = "INSERT INTO Areas (nombre, orden) VALUES (?, ?)";
$pdo->conn->prepare($sql)->execute([$_POST["nombre"], $max_orden]);

header("Location: ".$_SESSION["baseurl"]."/censo-areas.php");

?>