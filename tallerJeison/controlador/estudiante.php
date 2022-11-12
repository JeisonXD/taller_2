<?php

require_once '../modelo/estudiante.php';

class ControladorEstudiantes
{
    private $estudiante;

    public function __construct()
    {
        $this->estudiante = new Estudiante();
    }

    function validarCadena($cadena)
    {
        if (ctype_alpha($cadena)) {
            return true;
        } else {
            return false;
        }
    }

    function validarNumero($cadena)
    {
        if (ctype_digit($cadena)) {
            return true;
        } else {
            return false;
        }
    }

    function validarCampos($info)
    {
        if (!$this->validarCadena($info['Nombre'])) {
            return "El campo nombre solo debe contener caracteres alfabéticos";
        } else if (!$this->validarCadena($info['Ciudad'])) {
            return "El campo ciudad solo debe contener caracteres alfabéticos";
        } else if (!$this->validarNumero($info['Telefono'])) {
            return "El campo telefono solo debe contener caracteres numéricos";
        } else {
            return true;
        }
    }

    public function convertirAJson($info)
    {
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            "Resultado: " => $info
        ]);
    }

    function listarEstudiantes()
    {
        $listado = $this->estudiante->listarEstudiantes();
        $infoJson = $this->convertirAJson($listado);
        return $infoJson;
    }

    function registrarEstudiante($info)
    {
        $validacion = $this->validarCampos($info);
        if ($validacion) {
            $this->estudiante->registrarEstudiante($info);
            $infoJson = $infoJson = $this->convertirAJson($info);
            return $infoJson;
        } else {
            $infoJson = $this->convertirAJson($validacion);
            return $infoJson;
        }
    }

    function actualizarEstudiante($info)
    {
        $id = $info['id'];
        if ($this->estudiante->buscarEstudiante($id) != false) {
            $validacion = $this->validarCampos($info);
            if ($validacion) {
                $this->estudiante->actualizarEstudiante($info);
                $infoJson = $infoJson = $this->convertirAJson($info);
                return $infoJson;
            } else {
                $infoJson = $this->convertirAJson($validacion);
                return $infoJson;
            }
        } else {
            $infoJson = $this->convertirAJson("No se encontró el estudiante");
            return $infoJson;
        }
    }

    function eliminarEstudiante($info)
    {
        $id = $info['id'];
        if ($this->estudiante->buscarEstudiante($id) != false) {
            $resultado = $this->estudiante->eliminarEstudiante($info);
            $infoJson = $this->convertirAJson($resultado);
            return $infoJson;
        } else {
            $infoJson = $this->convertirAJson("No se encontró el estudiante");
            return $infoJson;
        }
    }
}
