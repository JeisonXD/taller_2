<?php

require_once '../modelo/nota.php';
require_once '../modelo/nota.php';
require_once '../modelo/bd.php';

class ControladorReportes
{
    private $mbd;

    public function __construct()
    {
        $this->mbd = BD::conexion();
    }

    public function convertirAJson($info)
    {
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            "Resultado: " => $info
        ]);
    }

    function parsearFechas($fecha)
    {
        try {
            $valores = explode('/', $fecha);
            if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
                return "{$valores[2]}-{$valores[1]}-{$valores[0]}";
            }
            return false;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function reporte($fechas)
    {
        $consulta = "select * from estudiantes inner join notas on estudiantes.id = notas.id_estudiante where notas.ingreso_nota between ? and ?";
        $stmt = $this->mbd->prepare($consulta);

        $fecha1 = $this->parsearFechas($fechas['fecha_ini']);
        $fecha2 = $this->parsearFechas($fechas['fecha_fin']);
        if ($fecha1 != false && $fecha2 != false) {
            $stmt->bindParam(1, $fecha1);
            $stmt->bindParam(2, $fecha2);

            $stmt->execute();
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->convertirAJson($rs);
        } else {
            return "Las fechas no tienen el formato dd/mm/yyyy";
        }
    }
}
