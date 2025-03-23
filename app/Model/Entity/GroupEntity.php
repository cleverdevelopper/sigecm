<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class GroupEntity{
        public $codigo_grupo;
        public $nome_grupo;                    
        public $descricao;                    
        public $permissoes;
        public $criado_em;
        public $atualizado_em;  

        
        public  function cadastrar(){
            $this->codigo_grupo = (new Database('grupos'))->insert([
                'nome_grupo'          => $this->nome_grupo,
                'descricao'           => $this->descricao,
                'permissoes'          => $this->permissoes,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
            return true;
        }

        public static function getGrupos($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('grupos'))->select($where, $order, $limit, $fields);
        }

        public static function getGrupoById($id){
            return self::getGrupos('codigo_grupo = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('grupos'))->update('codigo_grupo = '.$this->codigo_grupo, [
                'nome_grupo'          => $this->nome_grupo,
                'descricao'           => $this->descricao,
                'permissoes'          => $this->permissoes,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
        }

    }
?>