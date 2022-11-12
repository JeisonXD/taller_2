<?php

require_once 'bd.php';
require_once '../modelo/estudiante.php';

class Nota
{
    private $mbd;
    private $estudiante;

    public function __construct()
    {
        $this->estudiante = new Estudiante();
        $this->mbd = BD::conexion();
    }

    function buscarNota($id){
        $consulta = "select * from notas where id = ?";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarEstudiante($id_estudiante){
        $consulta = "select * from estudiantes where id = ?";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $id_estudiante);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function listarNotas()
    {
        $consulta = "select * from notas";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($rs); $i++) {
            $id_estudiante = $rs[$i]['id_estudiante'];
            $rs[$i]['Estudiante'] = $this->buscarEstudiante($id_estudiante);
        }
        return $rs;
    }

    function registrarNota($info)
    {
        $consulta = "insert into notas (nombre, ingreso_nota, consulta_nota, nota, corte, materia, email, id_estudiante) values (?,?,?,?,?,?,?,?)";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $info['nombre']);
        $stmt->bindParam(2, $info['ingreso_nota']);
        $stmt->bindParam(3, $info['consulta_nota']);
        $stmt->bindParam(4, $info['nota']);
        $stmt->bindParam(5, $info['corte']);
        $stmt->bindParam(6, $info['materia']);
        $stmt->bindParam(7, $info['email']);
        $stmt->bindParam(8, $info['id_estudiante']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function actualizarNota($info)
    {
        $consulta = "update notas set nombre = ?, ingreso_nota = ?, consulta_nota = ?, nota = ?, corte = ?, materia = ?, email = ? where id = ?";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $info['nombre']);
        $stmt->bindParam(2, $info['ingreso_nota']);
        $stmt->bindParam(3, $info['consulta_nota']);
        $stmt->bindParam(4, $info['nota']);
        $stmt->bindParam(5, $info['corte']);
        $stmt->bindParam(6, $info['materia']);
        $stmt->bindParam(7, $info['email']);
        $stmt->bindParam(8, $info['id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function eliminarNota($info){
        $rs = $this->buscarNota($info['id']);
        $consulta = "delete from notas where id = ?";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $info['id']);
        $stmt->execute();
        return $rs;
    }
}
