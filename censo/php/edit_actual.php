<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

if ($_POST["id"] == "-1") {
    $sql = "INSERT INTO Miembros (dni, apellidos, nombre, correo, telegram, telefono, centro, entrada) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $pdo->conn->prepare($sql)->execute([$_POST["dni"], $_POST["apellidos"], $_POST["nombre"], $_POST["correo"], $_POST["telegram"], $_POST["telefono"], $_POST["centro"], $_POST["entrada"]]);
} else {
    $sql = "UPDATE Miembros SET dni=?, apellidos=?, nombre=?, correo=?, telegram=?, telefono=?, centro=?, entrada=? WHERE id=?";
    $pdo->conn->prepare($sql)->execute([$_POST["dni"], $_POST["apellidos"], $_POST["nombre"], $_POST["correo"], $_POST["telegram"], $_POST["telefono"], $_POST["centro"], $_POST["entrada"], $_POST["id"]]);
}

header("Location: ".$_SESSION["baseurl"]."/censo-actual.php");

?>