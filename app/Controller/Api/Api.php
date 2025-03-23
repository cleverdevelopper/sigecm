<?php
    namespace App\Controller\Api;

    class Api{
        public static function getDetails($request){
            return[
                'name'      => 'SIGECM - API',
                'versao'    => 'v1.0.0',
                'autor'     => 'cleverdeveloper',
            ];
        }
    }

?>