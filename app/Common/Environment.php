<?php
    //classe responsavel por carregar todas a variaveis de ambiente
    namespace App\Common;

    class Environment{
        //funcao responsavel por carregar as variaveis de ambiente do projecto
        public static function load($dir){
            //verifica se o arquivo .env existe
            if(!file_exists($dir.'/.env')){
                return false;
            }
            //define as variaveis de ambiente
            $lines = file($dir.'/.env');
            foreach($lines as $line){
                putenv(trim($line));
            }
        }
    }
?>