<?php

require_once 'bd.php';

class Estudiante
{
    private $mbd;

    public function __construct()
    {
        
    }

    function buscarEstudiante($id){
        $consulta = "select * from estudiantes where id = ?";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function listarEstudiantes()
    {
        $consulta = "select * from estudiantes";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function registrarEstudiante($info)
    {
        $consulta = "insert into estudiantes (Nombre, Ciudad, Telefono) values (?,?,?)";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $info['Nombre']);
        $stmt->bindParam(2, $info['Ciudad']);
        $stmt->bindParam(3, $info['Telefono']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function actualizarEstudiante($info)
    {
        $consulta = "update estudiantes set Nombre = ?, Ciudad = ?, Telefono = ? where id = ?";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $info['Nombre']);
        $stmt->bindParam(2, $info['Ciudad']);
        $stmt->bindParam(3, $info['Telefono']);
        $stmt->bindParam(4, $info['id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function eliminarEstudiante($info){
        $rs = $this->buscarEstudiante($info['id']);
        $consulta = "delete from estudiantes where id = ?";
        $stmt = $this->mbd->prepare($consulta);
        $stmt->bindParam(1, $info['id']);
        $stmt->execute();
        return $rs;
    }
}
