<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . "/release/login.php");
}

require_once "conn/conn_mysql.php";

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

$sql = "SELECT id, fecha, asunto, descripcion FROM Plenos WHERE estado = 1";

$plenos = $pdo->get($sql)->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <?php include("UI/head.php"); ?>
    <!--<link href="edit_form.css" rel="stylesheet" type="text/css" />-->
</head>

<body class="skin-green">
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
                    Plenos
                    <small>Activos</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-table"></i>
                            Plenos</a></li>
                    <li class="active">Activos</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <?php
                foreach ($plenos as $p) {
                    echo <<< EOT

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3 class="box-title">{$p['asunto']}</h3>
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <p>{$p['descripcion']}</p>
                                            </div><!-- /.box-body -->
                                            <div class="box-footer clearfix">
                                                
                                            </div>
                                        </div><!-- /.box -->

                                    </div><!-- /.col -->

                                </div><!-- /.row -->
EOT;
                }
                ?>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="box" style="text-align:center">
                            <div class="box-header">
                                <h3 class="box-title">Nuevo</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <button class="btn btn-primary" id="nuevo_pleno">Generar</button>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                </div>

                <!-- edit form -->
                <div id="new_pleno-popup" title="Nuevo pleno">
                    <form action="nuevo.php" method="POST" class="edit_form-container">

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Asunto" name="asunto" required>
                        </div>

                        <div class="form-group">
                            <input type="date" class="form-control" placeholder="Fecha" name="fecha" required>
                        </div>

                        <div class="form-group">
                            <input type="time" class="form-control" placeholder="Hora" name="hora" required>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" rows="4" placeholder="Descripción" name="descripcion"></textarea>
                        </div>
                    </form>
                </div>
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <?php include("UI/footer.html"); ?>
        </footer>
    </div><!-- ./wrapper -->
    <?php include("UI/scripts.php"); ?>
    <script src="plenos/js/plenos.js" type="text/javascript"></script>
</body>

</html>