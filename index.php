<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . "/login.php");
}

header("Location: https://" . $_SERVER["HTTP_HOST"] . "/censo-actual.php");

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
                    Calendario
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-calendar"></i>
                            Calendario</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <?php include("UI/footer.html"); ?>
        </footer>
    </div><!-- ./wrapper -->

    <?php include("UI/scripts.php"); ?>
    
</body>

</html>