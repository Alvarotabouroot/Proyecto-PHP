<?php
namespace models;
use Lib\BaseDatos;
use PDO;
use PDOException;


class Evento extends BaseDatos{
    private string $id;
    private string $nombre;
    private string $fecha;
    private int $numParticipantes;


    public function __construct(){
        parent::__construct();
    }

    public function getId(){return $this->id;}
    public function setId($id){$this->id = $id;}

    public function getNombre(){return $this->nombre;}
    public function setNombre($nombre){$this->nombre = $nombre;}

    public function getFecha(){return $this->fecha;}
    public function setFecha($fecha){$this->fecha = $fecha;}

    public function getNumParticipantes(){return $this->numParticipantes;} 
    public function setNumParticipantes($numParticipantes){$this->numParticipantes = $numParticipantes;}

    public function crearEvento(){ 
        $stmt = $this->prepara("INSERT INTO eventos( nombre,fecha,numParticipantes) VALUES( :nombre, :fecha, :numParticipantes);");

        $nombre = $this->nombre;
        $fecha = $this->fecha;
        $numParticipantes = $this->numParticipantes;
    
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':numParticipantes', $numParticipantes, PDO::PARAM_INT);
    

        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
    }

    public function mostrarEventos(){
        $eventos = "SELECT * FROM eventos";
        $result = $this->prepara($eventos);

        try{
            $result->execute();
            return $result->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function actualizarNumParticipantes($num, $eventoid){
        $result = false;
        $cons = $this->prepara("UPDATE eventos SET numParticipantes = :numParticipantes WHERE id = :id");
        $cons->bindParam(':numParticipantes', $num, PDO::PARAM_INT);
        $cons->bindParam(':id',$eventoid,PDO::PARAM_INT);
        
        try{
            $cons->execute();
            $result = true;
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function buscarEvento($id){
        $eventos = "SELECT * FROM eventos where id = :id";
        $result = $this->prepara($eventos);
        $result->bindParam(':id', $id);
        
        try{
            $result->execute();
            return $result->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }
}