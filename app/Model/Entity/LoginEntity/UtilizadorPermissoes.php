<?php
    namespace App\Model\Entity\LoginEntity;
    use App\DatabaseManager\Database;

    class UtilizadorPermissoes{
        public $codigo_utilizador;
        public $nome_utilizador;
        public $utilizador;
        public $palavra_passe;
        public $grupos;         
        public $permissoes;     
        public $descricao_grupo; 
        public $departamento;
        public $descricao_departamento;


        public  function actualizar(){
            return (new Database('utilizadores_permissoes'))->update('codigo_utilizador = '.$this->codigo_utilizador, [
                'nome_utilizador'           => $this->nome_utilizador,
                'utilizador'                => $this->utilizador,
                'palavra_passe'             => $this->palavra_passe,
                'grupos'                    => $this->grupos,
                'permissoes'                => $this->permissoes,
                'descricao_grupo'           => $this->descricao_grupo,
                'departamento'              => $this->departamento,
                'descricao_departamento'    => $this->descricao_departamento
            ]);
        }

        public static function getUserByUsername($utilizador){
            return (new Database('utilizadores_permissoes')) -> select('utilizador = "'.$utilizador.'"')->fetchObject(self::class);
        }

        public static function getUsers($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('utilizadores_permissoes'))->select($where, $order, $limit, $fields);
        }

        public static function getUserById($id){
            return self::getUsers('codigo_utilizador = '.$id)->fetchObject(self::class);
        }
    }
?>