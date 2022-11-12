<?php

require_once '../controlador/nota.php';

$controlador = new ControladorNotas();
$info = json_decode(file_get_contents("php://input"), true);
if (!empty($info)) {
    echo ($controlador->eliminarNota($info));
} else {
    echo ("Solo se reciben los datos por POST");
}
