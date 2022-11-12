<?php

require_once '../controlador/estudiante.php';

$controlador = new ControladorEstudiantes();

echo($controlador->listarEstudiantes());