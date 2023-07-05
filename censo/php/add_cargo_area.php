<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

try {

    $sql = "INSERT INTO Cargos_por_area (area_id, nombre, orden) VALUES (?, ?, (SELECT * FROM (SELECT MAX(orden) + 1 FROM Cargos_por_area) c))";
    $pdo->conn->prepare($sql)->execute([$_POST["area_id"], $_POST["cargo"]]);

} catch (PDOException $e) {}

header("Location: ".$_SESSION["baseurl"]."/censo-areas.php");

?>