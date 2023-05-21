<?php
namespace models;
use Lib\BaseDatos;
use PDO;
use PDOException;


class Hermano extends BaseDatos{
    private string $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $password;
    private string $rol;
    private string $token;
    private string $token_esp;

    public function __construct(){
        parent::__construct();
    }

    public function getId():string{return $this->id;}

    public function setId($id){$this->id = $id;}

    public function getNombre():string{return $this->nombre;}

    public function setNombre(string $nombre){$this->nombre = $nombre;}

    public function getApellidos():string{return $this->apellidos;}

    public function setApellidos(string $apellidos){$this->apellidos = $apellidos;}

    public function getEmail():string{return $this->email;}

    public function setEmail(string $email){$this->email = $email;}

    public function getPassword():string{return $this->password;}

    public function setPassword(string $password){$this->password = $password;}

    public function getRol():string{return $this->rol;}

    public function setRol(string $rol){$this->rol = $rol;}

    public function getToken():string{return $this->token;}

    public function setToken(string $token){$this->token = $token;}

    public function getToken_esp():string{return $this->token_esp;}

    public function setToken_esp(string $token_esp){$this->token_esp = $token_esp;}

    public function registro(){ 
        $stmt = $this->prepara("INSERT INTO hermanos( nombre,apellidos,email,rol,password) VALUES( :nombre, :apellidos, :email, :rol, :password);");
        
        $nombre = $this->nombre;
        $apellidos = $this->apellidos;
        $email = $this->email;
        $rol = $this->rol;
        $password = $this->password;

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    

        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
        

    }

    public function buscaMail($email){
        $result = false;

        $cons = $this->prepara("SELECT * FROM hermanos WHERE email = :email");
        $cons->bindParam(':email',$email,PDO::PARAM_STR);


        try{
            $cons->execute();
            if($cons && $cons->rowCount()==1){
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function login($emailUsu){
        $result = false;
        $email = $emailUsu;
        $password = $this->getPassword();
        
        $usuario = $this->buscaMail($email);
                
        if($usuario !== false){
            $verify = password_verify($password, $usuario->password);
            if($verify){
                $result = $usuario;
            }
        }
        return $result;
    }

    public function getHermano($id){
        $hermano = "SELECT * FROM hermanos WHERE id = :id";
        $result = $this->prepara($hermano);
        $result->bindParam(":id",$id,PDO::PARAM_STR);

        try{
            $result->execute();
            return $result->fetch(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function validarData($data){
        if(isset($data->email) && isset($data->password)){
            return true;
        }else{
            return false;   
        }
    }

    public function updateToken(){
        $this->consulta("UPDATE hermanos SET token = '$this->token' WHERE email = '$this->email'");
        $this->consulta("UPDATE hermanos SET token_esp = '$this->token_esp' WHERE email = '$this->email'");

        try{
            return $this->filasAfectadas();
        }catch(PDOException $err){
            return false;
        }
    }
    
    public function buscaToken($token){
        $result = false;

        $cons = $this->prepara("SELECT * FROM hermanos WHERE token = :token");
        $cons->bindParam(':token',$token,PDO::PARAM_STR);

        try{
            $cons->execute();
            if($cons && $cons->rowCount()==1){
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }


    public function buscarTodosHermanos(){
        $usuarios = "SELECT * FROM hermanos";
        $result = $this->prepara($usuarios);

        try{
            $result->execute();
            return $result->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function buscarApellidos($apellidos){
        $hermano = "SELECT * FROM hermanos WHERE apellidos = :apellidos";
        $result = $this->prepara($hermano);
        $result->bindParam(":apellidos",$apellidos,PDO::PARAM_STR);

        try{
            $result->execute();
            return $result->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function cambiarPassword($id, $password){
        $result = false;
        $cons = $this->prepara("UPDATE hermanos SET password = :password WHERE id = :id");
        $cons->bindParam(':id',$id,PDO::PARAM_STR);
        $cons->bindParam(':password',$password,PDO::PARAM_STR);
        try{
            $cons->execute();
            $result = true;
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function editarDatos($id, $data){
        $result = false;
        $cons = $this->prepara("UPDATE hermanos SET nombre = :nombre, apellidos = :apellidos, email = :email  WHERE id = :id");
        $cons->bindParam(':id',$id,PDO::PARAM_STR);
        $cons->bindParam(':nombre',$data->nombre,PDO::PARAM_STR);
        $cons->bindParam(':apellidos',$data->apellidos,PDO::PARAM_STR);
        $cons->bindParam(':email',$data->email,PDO::PARAM_STR);

        try{
            $cons->execute();
            $result = true;
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function borrarHermano($id){
        $result = false;
        $cons = $this->prepara("DELETE FROM hermanos WHERE id = :id");
        $cons->bindParam(':id',$id);
        
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
