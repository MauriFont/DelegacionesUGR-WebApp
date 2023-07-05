<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

$sql = "UPDATE Cargos_por_area SET orden = orden-1 WHERE orden > (SELECT orden FROM Areas WHERE id=:id) ; 
DELETE FROM Cargos_por_area WHERE id=:id";

$pdo->conn->prepare($sql)->execute([":id"=>$_POST["id"]]);

?>