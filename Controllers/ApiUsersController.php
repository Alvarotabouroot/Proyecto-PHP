<?php

namespace Controllers;
use Models\Users;
use Lib\ResponseHttp;
use Lib\Pages;
use Lib\Security;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class ApiUsersController{

    private Users $user;

    public function __construct()
    {
        $this->user = new Users();
    }

    public function login($data){
        $logueado = false;
        $data = json_decode($data);
        $valido = $this->user->validarData($data);
        
        if($valido == true){
            $this->user->setPassword($data->password);
            $user = $this->user->login($data->email);
            
            if ($user && is_object($user)){
                if ($user->rol === 'admi'){
                    $_SESSION['admin'] = true;
                }
            }

            if($user){
                if(password_verify($data->password, $user->password)){
                    
                    $this->user->setEmail($data->email);
                    $key = Security::claveSecreta();
                    $token = Security::crearToken($key, [$data->email]);
                    $jwt = JWT::encode($token,$key,'HS256');

                    $this->user->setToken($jwt);
                    $this->user->setToken_esp($token["exp"]);
                    $this->user->updateToken();
                    //http_response_code(200);
                    ResponseHttp::statusMessage(200,'Ok');
                    $logueado = true;
                    return $logueado;
                }else{
                    //http_response_code(401);
                    ResponseHttp::statusMessage(401,'Contraseña invalida');
                    return $logueado;
                }
            }else{
                //http_response_code(400);
                ResponseHttp::statusMessage(400,'El usuario no existe');
                return $logueado;
            }
        }
    }

    public function registrar($data): void{
        $data = json_decode($data);
        $this->user->setNombre($data->nombre);
        $this->user->setEmail($data->email);
        $this->user->setRol('admi');
        $this->user->setPassword(password_hash($data->password, PASSWORD_BCRYPT, ['cost'=>4]));
        
        $result = $this->user->registro();
        
        if($result){
            ResponseHttp::statusMessage(202,'Usuario registrado');
            
        }else{
            ResponseHttp::statusMessage(400,'No se ha podido registrar el usuario');
        }
        
    }
}