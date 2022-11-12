<?php

require_once '../modelo/nota.php';

class ControladorNotas
{
    private $nota;

    public function __construct()
    {
        $this->estudiante = new Estudiante();
        $this->nota = new Nota();
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

    function validarFecha($fecha)
    {
        $valores = explode('/', $fecha);
        if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
            return true;
        }
        return false;
    }

    function validarEmail($email)
    {
        return (false !== filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    function validarCampos($info)
    {
        if (!$this->validarCadena($info['nombre'])) {
            return "El campo nombre solo debe contener caracteres alfabéticos";
        } else if (!$this->validarFecha($info['ingreso_nota'])) {
            return "El campo ingreso_nota debe estar en formato dd/mm/aaaa";
        } else if (!$this->validarFecha($info['consulta_nota'])) {
            return "El campo consulta_nota debe estar en formato dd/mm/aaaa";
        } else if ($info['nota'] > 5 || $info['nota'] < 0) {
            return "El campo nota solo debe estar estar entre 0 y 5";
        } else if (!$this->validarNumero($info['corte']) || $info['corte'] > 3 || $info['corte'] < 1) {
            return "El campo corte debe estar entre 1 y 3";
        } else if (!$this->validarCadena($info['materia'])) {
            return "El campo materia solo debe contener caracteres numéricos";
        } else if (!$this->validarEmail($info['email'])) {
            return "El campo email no es valido";
        }
    }

    public function convertirAJson($info)
    {
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            "Resultado: " => $info
        ]);
    }

    function listarNotas()
    {
        $listado = $this->nota->listarNotas();
        $infoJson = $this->convertirAJson($listado);
        return $infoJson;
    }

    function registrarNota($info)
    {
        $validacion = $this->validarCampos($info);
        if ($validacion) {
            $this->nota->registrarNota($info);
            $infoJson = $infoJson = $this->convertirAJson($info);
            return $infoJson;
        } else {
            $infoJson = $this->convertirAJson($validacion);
            return $infoJson;
        }
    }

    function actualizarNota($info)
    {
        $id = $info['id'];
        if ($this->nota->buscarNota($id) != false) {
            $validacion = $this->validarCampos($info);
            if ($validacion) {
                $this->nota->actualizarNota($info);
                $infoJson = $infoJson = $this->convertirAJson($info);
                return $infoJson;
            } else {
                $infoJson = $this->convertirAJson($validacion);
                return $infoJson;
            }
        } else {
            $infoJson = $this->convertirAJson("No se encontró la nota");
            return $infoJson;
        }
    }

    function eliminarNota($info)
    {
        $id = $info['id'];
        if ($this->nota->buscarNota($id) != false) {
            $resultado = $this->nota->eliminarNota($info);
            $infoJson = $this->convertirAJson($resultado);
            return $infoJson;
        } else {
            $infoJson = $this->convertirAJson("No se encontró la nota");
            return $infoJson;
        }
    }
}
