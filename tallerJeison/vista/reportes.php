<?php

require_once '../controlador/reportes.php';

$controlador = new ControladorReportes();
$info = json_decode(file_get_contents("php://input"), true);
if (!empty($info)) {
    echo ($controlador->reporte($info));
} else {
    echo ("Solo se reciben los datos por POST");
}