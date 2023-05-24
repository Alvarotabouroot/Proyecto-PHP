<?php 

namespace Utils;

class SaneaValida{
    public static function validaSaneaLogin($data){
        $errores = [];
        if(isset($data)){
            $email = $data['email'];
            $password = $data['password'];

            if (empty($email)){
                $errores["email"] = 'El campo email es obligatorio.';
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errores["email"] = "El formato del email es inválido";
            }

            if (empty($password)){
                $errores["password"] = 'El campo password es obligatorio.';
            }elseif(strlen($password) < 9 or strlen($password) > 20){
                $errores["password"] = "La contraseña tiene que estar entre 9 y 20 caracteres";
            }
                
        }
        return $errores;
    }


    public static function saneavalidaRegistroHermanos($data){
        $errores = [];
        
        if(isset($data)){
            if(isset($data['nombre'])){
                $nombre = $data['nombre'];
            }
            if(isset($data['apellidos'])){
                $apellidos = $data['apellidos'];
            }
            if(isset($data['email'])){
                $email = $data['email'];
            }

            if (empty($email)){
                $errores["email"] = 'El campo email es obligatorio.';
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errores["email"] = "El formato del email es inválido";
            }

            if (empty($nombre)){
                $errores["nombre"] = 'El campo nombre es obligatorio.';
            }
            
            if (empty($apellidos)){
                $errores["apellidos"] = 'El campo apellidos es obligatorio.';
            }
        }
        return $errores;
    }

    public static function saneavalidaRegistroAdmi($data){
        $errores = [];
        
        if(isset($data)){
            if(isset($data['nombre'])){
                $nombre = $data['nombre'];
            }
            if(isset($data['password'])){
                $password = $data['password'];
            }
            if(isset($data['email'])){
                $email = $data['email'];
            }

            if (empty($email)){
                $errores["email"] = 'El campo email es obligatorio.';
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errores["email"] = "El formato del email es inválido";
            }

            if (empty($nombre)){
                $errores["nombre"] = 'El campo nombre es obligatorio.';
            }
            
            if (empty($password)){
                $errores["password"] = 'El campo password es obligatorio.';
            }elseif(strlen($password) < 9 or strlen($password) > 20){
                $errores["password"] = "La contraseña tiene que estar entre 9 y 20 caracteres";
            }
        }
        return $errores;
    }

    public static function validaSaneaEdicion($data){
        $errores = [];
        
        if(isset($data)){
            if(isset($data['nombre'])){
                $nombre = $data['nombre'];
            }
            if(isset($data['apellidos'])){
                $apellidos = $data['apellidos'];
            }
            if(isset($data['email'])){
                $email = $data['email'];
            }

            if (empty($email)){
                $errores["email"] = 'El campo email es obligatorio.';
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errores["email"] = "El formato del email es inválido";
            }

            if (empty($nombre)){
                $errores["nombre"] = 'El campo nombre es obligatorio.';
            }
            
            if (empty($apellidos)){
                $errores["apellidos"] = 'El campo apellidos es obligatorio.';
            }
        }
        return $errores;
    }
}