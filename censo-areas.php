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

$sql = "SELECT Cargos.id as id, Cargos_por_area.area_id as area_id, miembro_id, Miembros.nombre as nombre, Miembros.apellidos as apellidos, cargo_id, orden
FROM Cargos
INNER JOIN Cargos_por_area
ON Cargos_por_area.id = Cargos.cargo_id
INNER JOIN Miembros
ON Miembros.id = Cargos.miembro_id";

$miembros = $pdo->get($sql)->fetchAll();

$sql = "SELECT id, nombre, orden FROM Areas ORDER BY orden ASC";
$areas = $pdo->getUnique($sql);;

$sql = "SELECT id, area_id, nombre, orden FROM Cargos_por_area ORDER BY orden ASC";
$cargos = $pdo->getUnique($sql);
?>

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
                    <small>Areas</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-table"></i>
                            Censo</a></li>
                    <li class="active">Areas</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Las areas y sus integrantes</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">

                                <?php
                                $max_ar = count($areas);
                                $encoded = json_encode($cargos);
                                echo "<script>const total_areas = $max_ar;</script>";
                                echo "<script>const list_cargos = $encoded;</script>";

                                foreach ($areas as $a_k => $a) {

                                    $cs_por_area = array_filter($cargos, function ($val) use ($a_k) {
                                        return $val["area_id"] == $a_k;
                                    });
    
                                    uasort($cs_por_area, function ($a, $b) {
                                        return $a["orden"] - $b["orden"];
                                    });
    
                                    $max_ca = count($cs_por_area);

                                    $disp_none = 'style="display: none"';
                                    $moveup = ($a["orden"] == 1) ? $disp_none : "";
                                    $movedown = ($a["orden"] == $max_ar) ? $disp_none : "";
                                    echo <<< EOT
                                                    <table class="table table-bordered table-hover margin-bottom" orden="{$a["orden"]}" areaid="$a_k" maxcargos="$max_ca">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2">
                                                                    <span class="area_name">{$a["nombre"]}</span>
                                                                    <div class="areas-btns mousenter-dots"><i class="fa fa-ellipsis"></i></div>
                                                                    <div class="areas-btns mousenter-btns" style="visibility: hidden">
                                                                        <button class='btn btn-secondary moveup_area' $moveup><i class='fa fa-arrow-up'></i></button>
                                                                        <button class='btn btn-secondary movedown_area' $movedown><i class='fa fa-arrow-down'></i></button>
                                                                        <button class="btn btn-secondary edit_area"><i class="fa fa-edit"></i></button>
                                                                        <button class="btn btn-success confirm_area" style="display: none"><i class="fa fa-edit"></i></button>
                                                                        <button class="btn btn-secondary admin_cargos"><i class="fa fa-briefcase"></i></button>
                                                                        <button type="button" class="btn btn-danger delete_area"><i class="fa fa-trash"></i></button>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
EOT;

                                    foreach ($cs_por_area as $c_k => $c) {

                                        $m_por_cargo = array_filter($miembros, function ($val) use ($a_k, $c_k) {
                                            return $val["area_id"] == $a_k && $val["cargo_id"] == $c_k;
                                        });

                                        sort($m_por_cargo);

                                        $moveup = ($c["orden"] == 1) ? $disp_none : "";
                                        $movedown = ($c["orden"] == $max_ca) ? $disp_none : "";

                                        echo <<< EOT
                                            <tr cargoid="$c_k" orden="{$c["orden"]}">
                                                <td class="table-subt">
                                                    <span class="cargo_name">{$c["nombre"]}</span>
                                                    <div class="areas-btns mousenter-dots"><i class="fa fa-ellipsis"></i></div>
                                                    <div class="areas-btns mousenter-btns" style="visibility: hidden">
                                                        <button class='btn btn-secondary moveup_cargo' $moveup><i class='fa fa-arrow-up'></i></button>
                                                        <button class='btn btn-secondary movedown_cargo' $movedown><i class='fa fa-arrow-down'></i></button>
                                                        <button class="btn btn-secondary edit_cargo"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-success confirm_cargo" style="display: none"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-danger delete_cargo"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
EOT;
                                        
                                        $primero = "";

                                        if (isset($m_por_cargo[0])) {
                                           $primero = $m_por_cargo[0]["apellidos"] . ", " . $m_por_cargo[0]["nombre"];

                                            echo <<< EOT
                                                <td m_cargoid="{$m_por_cargo[0]["id"]}">
                                                    <span>$primero</span>
                                                    <div class="areas-btns mousenter-dots"><i class="fa fa-ellipsis"></i></div>
                                                    <div class="areas-btns mousenter-btns" style="visibility: hidden">
                                                        <button class="btn btn-danger remove_miembro"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
EOT;                                    
                                        } else {
                                            echo "<td></td>";
                                        }
                                        foreach (array_slice($m_por_cargo, 1) as $m) {
                                            echo <<< EOT
                                                <tr cargoid="$c_k">
                                                    <td></td>
                                                    <td m_cargoid="{$m["id"]}">
                                                        <span>{$m["apellidos"]}, {$m["nombre"]}</span>
                                                        <div class="areas-btns mousenter-dots"><i class="fa fa-ellipsis"></i></div>
                                                        <div class="areas-btns mousenter-btns" style="visibility: hidden">
                                                            <button class="btn btn-danger remove_miembro"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
EOT;
                                        }
                                    }

                                    echo <<< EOT
                                        <tr>
                                            <td colspan="2" style="text-align:right;"><button class="btn btn-primary add_miembro_area">Añadir miembro</button></td>
                                        </tr>
                                            
EOT;
                                    echo "</tbody></table>";
                                }
                                ?>

                                <div class="row" style="margin-top: 2rem">
                                    <div class="col-xs-12">
                                        <div class="box" style="text-align:center">
                                            <div class="box-header">
                                                <form action="censo/php/nueva_area.php" method="POST">
                                                    <div style="display: inline-block">
                                                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" required>
                                                    </div>
                                                    <div style="display: inline-block">
                                                        <input type="submit" value="Crear Area" class="btn btn-primary" style="display: inline-block ; vertical-align:unset">
                                                        <!--<button type="submit" class="btn btn-primary" id="nueva_area">Crear Area</button> -->
                                                    </div>
                                                </form>
                                            </div><!-- /.box-header -->
                                        </div><!-- /.box -->
                                    </div>
                                </div>

                                <div id="dialog-borrar-area" title="Eliminar area">
                                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>¿Realmente deseas eliminar el area <span class="nom_area"></span>?</p>
                                </div>

                                <div id="dialog-borrar-cargo" title="Eliminar cargo">
                                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>¿Realmente deseas eliminar el cargo <span class="nom_cargo"></span>?</p>
                                </div>

                                <div id="dialog-borrar-mcargo" title="Remover miembro">
                                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>¿Realmente deseas remover a <b><span class="nom_mcargo"></span></b> del area <b><span class="nom_area"></span></b>?</p>
                                </div>

                                <div id="dialog_add_c" title="Crear Cargo">
                                    <br>
                                    <form action="censo/php/add_cargo_area.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Area" required disabled>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Cargo" name="cargo" required>
                                        </div>

                                        <input type="hidden" name="area_id">
                                    </form>
                                </div>

                                <div class="add_miem-popup" id="dialog_add_m" title="Añadir miembro">
                                    <form action="censo/php/add_miembro_area.php" method="POST" class="edit_form-container">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Area" required disabled>
                                        </div>

                                        <div class="form-group">
                                            <select name="cargo_id" class="form-control" required>
                                                <option value="" selected disabled hidde>SELECCIONAR</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                        <span id="cargando_m" style="color:red ; display: none">Cargando miembros...</span>
                                            <select name="miembro_id" class="form-control" required>
                                                <option value="" selected disabled hidde>SELECCIONAR</option>
                                            </select>
                                        </div>
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