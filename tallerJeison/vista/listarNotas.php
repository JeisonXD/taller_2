<?php

require_once '../controlador/nota.php';

$controlador = new ControladorNotas();

echo($controlador->listarNotas());