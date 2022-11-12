<?php

require_once '../controlador/estudiante.php';

$controlador = new ControladorEstudiantes();
$info = json_decode(file_get_contents("php://input"), true);
if (!empty($info)) {
    echo ($controlador->eliminarEstudiante($info));
} else {
    echo ("Solo se reciben los datos por POST");
}
