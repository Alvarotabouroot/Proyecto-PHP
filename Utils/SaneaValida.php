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
            }elseif(filter_var(htmlspecialchars($password))){
                $errores["password"] = "La contraseña no tiene un formato valido";
            }
                
        }
        return $errores;
    }
}