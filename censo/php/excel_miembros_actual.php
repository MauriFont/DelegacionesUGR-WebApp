<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location: ".$_SESSION["baseurl"]."/login.php");
}

require_once $_SESSION["root"].'/conn/conn_mysql.php';

spl_autoload_register(function ($class) {
    include $_SESSION["root"]."/plugins/".str_replace("\\","/", $class) . '.php';
});

$db = getenv("DB_NAME") . $_SESSION["centro"];
$pdo = new MySQL_PDO($db);

$sql = "SELECT id, dni, apellidos, nombre, correo, telegram, telefono, centro, entrada
FROM Miembros WHERE DATE(salida) = '0000-00-00' ORDER BY apellidos";

$miembros = $pdo->get($sql)->fetchAll();

$sql = "SELECT id, nombre FROM Centros ORDER BY nombre ASC";
$centros = $pdo->getUnique($sql);

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$helper = new Sample();
if ($helper->isCli()) {
    return;
}

$spreadsheet = new Spreadsheet();

$spreadsheet->getProperties()
    ->setCreator($_SESSION["apellidos"].", ".$_SESSION["nombre"])
    ->setTitle('Lista de miembros');
$activa = $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'DNI')
                        ->setCellValue('B1', 'Apellidos')
                        ->setCellValue('C1', 'Nombre')
                        ->setCellValue('D1', 'Correo')
                        ->setCellValue('E1', 'Telegram')
                        ->setCellValue('F1', 'Telefono')
                        ->setCellValue('G1', 'Centro')
                        ->setCellValue('H1', 'Entrada');

foreach ($miembros as $k => $m) {
    $k += 2;
    $activa->setCellValue('A'.$k, $m["dni"])
            ->setCellValue('B'.$k, $m["apellidos"])
            ->setCellValue('C'.$k, $m["nombre"])
            ->setCellValue('D'.$k, $m["correo"])
            ->setCellValue('E'.$k, $m["telegram"])
            ->setCellValue('F'.$k, $m["telefono"])
            ->setCellValue('G'.$k, $centros[$m['centro']]["nombre"])
            ->setCellValue('H'.$k, $m["entrada"]);
}

$activa->setTitle('Actual');

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="lista_miembros_actual.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('php://output');
exit;

?>