<?php 

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;

class Users extends BaseDatos{
    private string $id;
    private string $nombre;
    private string $email;
    private string $password;
    private string $rol;
    private string $token;
    private int $token_esp;
    
    public function __construct(){
        parent::__construct();
    }

    public function getId():string{
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNombre():string{
        return $this->nombre;
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    public function getEmail():string{
        return $this->email;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }

    public function getPassword():string{
        return $this->password;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function getRol():string{
        return $this->rol;
    }

    public function setRol(string $rol){
        $this->rol = $rol;
    }

    public function getToken():string{
        return $this->token;
    }

    public function setToken(string $token){
        $this->token = $token;
    }

    public function getToken_esp():int{
        return $this->token_esp;
    }

    public function setToken_esp(int $token_esp){
        $this->token_esp = $token_esp;
    }

    public function registro(){ 
        $stmt = $this->prepara("INSERT INTO users( nombre,email,rol,password) VALUES( :nombre, :email, :rol, :password);");

        $nombre = $this->nombre;
        $email = $this->email;
        $rol = $this->rol;
        $password = $this->password;
    
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
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

    public function buscaEmail($email){
        $result = false;

        $cons = $this->prepara("SELECT * FROM users WHERE email = :email");
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

    public function login($email){
        $result = false;
        $password = $this->getPassword();
        $usuario = $this->buscaEmail($email);
        if(is_object($usuario)){
            $verify = password_verify($password, $usuario->password);
            if($verify){
                $result = $usuario;
            }
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
    public function buscaToken($token){
        $result = false;

        $cons = $this->prepara("SELECT * FROM users WHERE token = :token");
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
    
    public function updateToken(){
        $this->consulta("UPDATE users SET token = '$this->token' WHERE email = '$this->email'");
        $this->consulta("UPDATE users SET token_esp = '$this->token_esp' WHERE email = '$this->email'");

        try{
            return $this->filasAfectadas();
        }catch(PDOException $err){
            return false;
        }
    }
}