<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$_SESSION["root"] = realpath($_SERVER["DOCUMENT_ROOT"]);
$_SESSION["baseurl"] = "https://" . $_SERVER["HTTP_HOST"];

if (isset($_SESSION["correo"])) {
    header("Location: https://" . $_SERVER["HTTP_HOST"]);
}

require_once 'conn/conn_mysql.php';

$pdo = new MySQL_PDO(getenv("DB_NAME")."DGE");

$stmt = $pdo->conn->prepare("SELECT id, acronimo FROM Centros ORDER BY acronimo");
$stmt->execute();
$centros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!--
    Author  Mauricio Fontebasso
    Support <https://github.com/MauriFont/DelegacionesUGR-WebApp>
    Email   <elfontex80@gmail.com>
    license MIT <http://opensource.org/licenses/MIT>
-->

<!DOCTYPE html>
<html>

<head>
    <title>Delegaciones UGR | Iniciar Sesión</title>
    <?php include("UI/head.php"); ?>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            Delegaciones<b>UGR</b>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Selecciona la delegación a la que deseas acceder</p>
            <form id="login_form" method="POST" action="login/php/server-login.php">
                <div class="form-group has-feedback">
                    <select class="form-control" name="acronimo" id="sele_centros" onchange="showGoogle()">
                        <option value='' disabled selected>Seleccionar...</option>
                        <?php
                            foreach ($centros as $c) {
                                echo "<option value='" . $c["acronimo"] . "'>" . $c["acronimo"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <input id="i_credential" name="credential" type="hidden">
                <div id="google_signin" class="form-group has-feedback">
                </div>
            </form>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <?php include("UI/scripts.php"); ?>

    <!-- Google Sign in-->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <script src="login/js/login.js" type="text/javascript"></script>

</body>

</html>