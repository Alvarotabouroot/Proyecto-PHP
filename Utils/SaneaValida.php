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
}