<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class DepartamentoEntity{
        public $codigo_departamento;
        public $nome_departamento;
        public $descricao;
        public $criado_em;
        public $atualizado_em;                      
        
        public  function cadastrar(){
            $this->codigo_departamento = (new Database('departamentos'))->insert([
                'nome_departamentO'           => $this->nome_departamento,
                'descricao'                   => $this->descricao,
                'criado_em'                   => $this->criado_em,
                'atualizado_em'               => $this->atualizado_em
            ]);
            return true;
        }

        public static function getDepartamentos($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('departamentos'))->select($where, $order, $limit, $fields);
        }

        public static function getEDepartamentoById($id){
            return self::getDepartamentos('codigo_departamento = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('departamentos'))->update('codigo_departamento = '.$this->codigo_departamento, [
                'nome_departamentO'           => $this->nome_departamento,
                'descricao'                   => $this->descricao,
                'criado_em'                   => $this->criado_em,
                'atualizado_em'               => $this->atualizado_em
            ]);
        }

    }
?>