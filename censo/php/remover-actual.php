<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

$sql = "UPDATE Miembros SET salida=? WHERE id=?";
$pdo->conn->prepare($sql)->execute([$_POST["salida"], $_POST["id"]]);

header("Location: ".$_SESSION["baseurl"]."/censo-actual.php");

?>