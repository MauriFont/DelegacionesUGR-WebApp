<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

try {

    $sql = "INSERT INTO Cargos (cargo_id, miembro_id) VALUES (?, ?)";
    $pdo->conn->prepare($sql)->execute([$_POST["cargo_id"], $_POST["miembro_id"]]);

} catch (PDOException $e) {}

header("Location: ".$_SESSION["baseurl"]."/censo-areas.php");

?>