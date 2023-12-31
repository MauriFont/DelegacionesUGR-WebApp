<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . "/login.php");
}

require_once 'conn/conn_mysql.php';

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

$sql = "SELECT id, dni, apellidos, nombre, correo, telegram, telefono, centro, entrada, salida
FROM Miembros WHERE DATE(salida) != '0000-00-00' ORDER BY apellidos";

$miembros = $pdo->get($sql)->fetchAll();

$sql = "SELECT id, nombre FROM Centros ORDER BY nombre ASC";
$centros = $pdo->getUnique($sql);

?>

<!--
    Author  Mauricio Fontebasso
    Support <https://github.com/MauriFont/DelegacionesUGR-WebApp>
    Email   <elfontex80@gmail.com>
    All rights reserved
-->

<!DOCTYPE html>
<html>

<head>
    <?php include("UI/head.php"); ?>
</head>

<body class="skin-green fixed">
    <div class="wrapper">

        <header class="main-header">
            <?php include("UI/header.php"); ?>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <?php include("UI/menu.php"); ?>
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Censo
                    <small>Histórico</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-table"></i>
                            Censo</a></li>
                    <li class="active">Histórico</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Exmiembros de la delegación</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="t_censo" class="table
                                                table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Apellidos</th>
                                            <th>Nombre</th>
                                            <th>DNI</th>
                                            <th>Correo</th>
                                            <th>Telegram</th>
                                            <th>Telefono</th>
                                            <th>Centro</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($miembros as $m) {
                                            echo <<< EOT
                                                    <tr>
                                                        <td column="apellidos">{$m['apellidos']}</td>
                                                        <td column="nombre">{$m['nombre']}</td>
                                                        <td column="dni">{$m['dni']}</td>
                                                        <td column="correo">{$m['correo']}</td>
                                                        <td column="telegram">{$m['telegram']}</td>
                                                        <td column="telefono">{$m['telefono']}</td>
                                                        <td column="centro" centroid="{$m['centro']}">{$centros[$m['centro']]["nombre"]}</td>
                                                        <td column="entrada">{$m['entrada']}</td>
                                                        <td column="salida">{$m['salida']}</td>
                                                        <td><button miembroid="{$m['id']}" class="edit_actual"><i class="fa fa-edit"></i></button></td>
                                                    </tr>
                                                EOT;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Apellidos</th>
                                            <th>Nombre</th>
                                            <th>DNI</th>
                                            <th>Correo</th>
                                            <th>Telegram</th>
                                            <th>Telefono</th>
                                            <th>Centro</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <!-- edit form -->
                                <div class="edit_form-popup" id="dialog-edit-actual" title="Editar miembro">
                                    <form action="censo/php/edit_actual.php" method="POST" class="edit_form-container">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="DNI" name="dni" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Correo" name="correo" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Telegram" name="telegram" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Telefono" name="telefono" required>
                                        </div>

                                        <div class="form-group">
                                            <select name="centro" class="form-control" required>
                                                <option value="" selected disabled hidde>SELECCIONAR</option>
                                                <?php
                                                    foreach ($centros as $k=>$c) {
                                                        echo <<< EOT
                                                            <option value="$k">{$c["nombre"]}</option>
                                                        EOT;
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="date" class="form-control" placeholder="Entrada" name="entrada" required>
                                        </div>

                                        <input type="hidden" name="id">
                                    </form>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <?php include("UI/footer.html"); ?>
        </footer>
    </div><!-- ./wrapper -->
    <?php include("UI/scripts.php"); ?>
    <script src="censo/js/censo.js" type="text/javascript"></script>
</body>

</html>