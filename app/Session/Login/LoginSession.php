<?php
    namespace App\Session\Login;

    class LoginSession{
        private static function init(){
            if(session_status() != PHP_SESSION_ACTIVE){
                session_start();
            }
        }

        public static function login($objUser){
            self::init();
            $_SESSION['admin']['utilizador'] = [
                'id'                => $objUser->codigo_utilizador,
                'nome_utilizador'   => $objUser->nome_utilizador,
                'permissoes'        => $objUser->permissoes
            ]; 
            return true;  
        }

        public static function isLoged(){
            self::init();
            return isset($_SESSION['admin']['utilizador']['id']);
        }

        public static function logout(){
            self::init();
            unset($_SESSION['admin']['utilizador']);
            return true;
        }
    }
?>