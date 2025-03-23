<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class Utilizador{
        public $id_utilizador;
        public $utilizador;                    
        public $nome;                                        
        public $email;
        public $descricao_grupo;                           
    

        public static function getUtilizadores($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('utilizadores'))->select($where, $order, $limit, $fields);
        }

        public static function getUtilizadorById($id){
            return self::getUtilizadores('id_utilizador = '.$id)->fetchObject(self::class);
        }

    }

?>