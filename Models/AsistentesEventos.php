<?php
namespace models;
use Lib\BaseDatos;
use PDO;
use PDOException;


class AsistentesEventos extends BaseDatos{
    private string $id;
    private int $hermano_id;
    private int $evento_id;

    public function __construct(){
        parent::__construct();
    }

    public function getHermano_id(){return $this->hermano_id;}
    public function setHermano_id($hermano_id){$this->hermano_id = $hermano_id;}

    public function getEvento_id(){return $this->evento_id;}
    public function setEvento_id($evento_id){$this->evento_id = $evento_id;}

    public function apuntarseEvento($data){ 
        $stmt = $this->prepara("INSERT INTO asistenteseventos(hermano_id, evento_id) VALUES( :hermano_id, :evento_id);");

        $stmt->bindParam(':hermano_id', $data->idhermano, PDO::PARAM_INT);
        $stmt->bindParam(':evento_id', $data->idevento, PDO::PARAM_INT);
    
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
    }

    public function verNumParticipantes($id){
        $eventos = "SELECT hermano_id FROM asistenteseventos WHERE evento_id = :evento_id";
        $result = $this->prepara($eventos);
        $result->bindParam('evento_id', $id, PDO::PARAM_INT);

        try{
            $result->execute();
            return $result->rowCount();
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function buscarParticipante($data){
        $result = false;
        $cons = $this->prepara("SELECT * FROM asistenteseventos WHERE hermano_id = :hermano_id AND evento_id = :evento_id");
        $cons->bindParam(':hermano_id',$data->idhermano,PDO::PARAM_STR);
        $cons->bindParam(':evento_id',$data->idevento,PDO::PARAM_STR);

        try{
            $cons->execute();
            if($cons->rowCount()==1){
                $result = true;
            }else{
                $result = false;
            }
        }catch(PDOException $err){
            return $err;
        }
        return $result;
    }

    public function buscarEvento($id){
        $eventos = "SELECT * FROM asistenteseventos WHERE evento_id = :evento_id";
        $result = $this->prepara($eventos);
        $result->bindParam(':evento_id', $id);

        try{
            $result->execute();
            return $result->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function misEventos($id){
        $eventos = "SELECT * FROM asistenteseventos WHERE hermano_id = :hermano_id";
        $result = $this->prepara($eventos);
        $result->bindParam(':hermano_id', $id);

        try{
            $result->execute();
            return $result->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function borrarLinea($hermanoid, $eventoid){
        $result = false;
        $cons = $this->prepara("DELETE FROM asistenteseventos WHERE hermano_id = :hermano_id AND evento_id = :evento_id");
        $cons->bindParam(':hermano_id',$hermanoid);
        $cons->bindParam(':evento_id',$eventoid);

        try{
            $cons->execute();
            if($cons){
                $result = true;
            }else{
                $result = false;
            }
        }catch(PDOException $err){
            return $err;
        }
        return $result;
    }
}