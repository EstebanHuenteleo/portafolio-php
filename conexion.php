<?php
// Conexion a la base de datos
class conexion
{

    private $servidor = "localhost";
    private $usuario = "root";
    private $contrasenia = "";
    private $conexion;

    public function __construct()
    {
        try {
            $this->conexion = new PDO("mysql:host=$this->servidor;dbname=album", $this->usuario, $this->contrasenia);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Instruccion que regresa el ultimo id insertado
    public function ejecutar($sql)
    { //Insertar/Actualizar/Eliminar
        $this->conexion->exec($sql);
        return $this->conexion->lastInsertId();
    }
    public function consultar($sql)
    { //Consultar
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        // fetchAll() regresa un array con todos los registros
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
