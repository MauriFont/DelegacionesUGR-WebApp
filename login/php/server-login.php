<?php

session_start();

require_once $_SESSION["root"].'/plugins/google/vendor/autoload.php';
require_once $_SESSION["root"].'/conn/conn_mysql.php';

$db = getenv("DB_NAME").$_POST["acronimo"];
$pdo = new MySQL_PDO($db);
$CLIENT_ID="501337473441-9ir62atud8q43j4fo6m63mkegi7673qh.apps.googleusercontent.com";

// Get $id_token via HTTPS POST.
$id_token = $_POST["credential"];

$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);

if ($payload) {
    $sql = "SELECT Miembros.nombre, Miembros.apellidos FROM Acceso INNER JOIN Miembros ON Acceso.miembro_id = Miembros.id WHERE Acceso.correo = ?";
    $miembro = $pdo->get($sql, array($payload['email']))->fetch();

    if ($miembro) {
        $_SESSION["correo"] = $payload['email'];
        $_SESSION["nombre"] = $miembro['nombre'];
        $_SESSION["apellidos"] = $miembro['apellidos'];
        $_SESSION["nom_compl"] = $_SESSION["nombre"] . " " . $_SESSION["apellidos"];
        $_SESSION["foto"] = $payload['picture'];
        $_SESSION["centro"] = $_POST["acronimo"];
    } else {
        session_destroy();
    }
    header("Location: ".$_SESSION["baseurl"]."/index.php");
} else {
  session_destroy();
}

?>