<?php 

namespace Controllers;
use Models\Hermano;
use Lib\ResponseHttp;
use Lib\Pages;
use Lib\Security;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiHermanoController{
    
    private Hermano $hermano;

    public function __construct()
    {
        $this->hermano = new Hermano();
    }

    public function registrar($data): void{
        $data = json_decode($data);
        $this->hermano->setNombre($data->nombre);
        $this->hermano->setApellidos($data->apellidos);
        $this->hermano->setEmail($data->email);
        $this->hermano->setRol('hermano');
        $this->hermano->setPassword(password_hash('hermandad', PASSWORD_BCRYPT, ['cost'=>4]));
        
        $result = $this->hermano->registro();
        
        if($result){
            ResponseHttp::statusMessage(201,'Usuario registrado');
            
        }else{
            ResponseHttp::statusMessage(400,'No se ha podido registrar el usuario');
        }
        
    }

    public function login($data){
        $data = json_decode($data);
        $valido = $this->hermano->validarData($data);
        
        if($valido == true){
            $this->hermano->setPassword($data->password);
            $hermano = $this->hermano->login($data->email);
            
            if ($hermano && is_object($hermano)){
                $_SESSION['identity'] = $hermano;
            }

            if($hermano){
                if(password_verify($data->password, $hermano->password)){
                    
                    $this->hermano->setEmail($data->email);
                    $key = Security::claveSecreta();
                    $token = Security::crearToken($key, [$data->email]);
                    $jwt = JWT::encode($token,$key,'HS256');

                    $this->hermano->setToken($jwt);
                    $this->hermano->setToken_esp($token["exp"]);
                    $this->hermano->updateToken();
                    //http_response_code(200);
                    ResponseHttp::statusMessage(200,'Ok');
                    
                    return $hermano;
                }else{
                    //http_response_code(401);
                    ResponseHttp::statusMessage(401,'Contraseña invalida');
                }
            }else{
                //http_response_code(400);
                ResponseHttp::statusMessage(400,'El usuario no existe');
            }
        }
    }

    public function buscarTodosHermanos(){
        $hermanos = $this->hermano->buscarTodosHermanos();
        
        if($hermanos){
            ResponseHttp::statusMessage(202,'Todos los hermanos han sido cargados');
            
        }else{
            ResponseHttp::statusMessage(206,'No se han podido cargar todos los hermanos');
        }
        
        $hermanos = json_encode($hermanos);
        return $hermanos;
    }

    public function buscarHermano($apellidos){
        $hermano = $this->hermano->buscarApellidos($apellidos);

        if($hermano){
            ResponseHttp::statusMessage(200, 'OK');
        }else{
            ResponseHttp::statusMessage(204, 'No se ha podido cargar el hermano');
        }
        $hermano = json_encode($hermano);
        return $hermano;
    }

    public function buscarHermanoID($id){
        $hermano = $this->hermano->getHermano($id);
        if($hermano){
            ResponseHttp::statusMessage(200, 'OK');
        }else{
            ResponseHttp::statusMessage(204, 'No se ha podido cargar el hermano');
        }
        $hermano = json_encode($hermano);
        return $hermano;
    }
    public function cambiarPassword($id, $contraseña){
        $id = json_decode($id);
        $contraseña = json_decode($contraseña);
        
        $contraseña = password_hash($contraseña, PASSWORD_BCRYPT, ['cost'=>4]);
        $result = $this->hermano->cambiarPassword($id, $contraseña);
        if($result){
            ResponseHttp::statusMessage(200, 'OK');
        }else{
            ResponseHttp::statusMessage(304, 'No se ha podido modificar la contraseña');
        }

        return $result;
    }

    public function editarDatos($id, $data){
        $data = json_decode($data);
        $id = json_decode($id);
        $result = $this->hermano->editarDatos($id, $data);

        if($result){
            ResponseHttp::statusMessage(200, 'OK');
        }else{
            ResponseHttp::statusMessage(304, 'No se han podido modificar los datos');
        }

        return $result;
    }

    public function borrarHermano($id){
        $id = json_decode($id);
        $result = $this->hermano->borrarHermano($id);

        if($result){
            ResponseHttp::statusMessage(200, 'Borrado con exito');
        }else{
            ResponseHttp::statusMessage(400, 'No se ha podido borrar');
        }
    }
}