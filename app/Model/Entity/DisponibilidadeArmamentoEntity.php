<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class DisponibilidadeArmamentoEntity{
        public $codigo_disponibilidade;
        public $disponibilidade;        


        public  function cadastrar(){
            $this->codigo_disponibilidade = (new Database('disponibilidade_armamento'))->insert([
                'status'     =>  $this->disponibilidade
            ]);
            return true;
        }

        public static function getDisponibilidade($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('disponibilidade_armamento'))->select($where, $order, $limit, $fields);
        }

        public static function getDisponibilidadeById($id){
            return self::getDisponibilidade('codigo_disponibilidade = '.$id)->fetchObject(self::class);
        }

        /*public  function actualizar(){
            return (new Database('senha_config'))->update('codigo_senha_reset = '.$this->codigo_senha_reset, [
                'palavra_passe'     =>  $this->palavra_passe,
                'descricao'         =>  $this->descricao,
                'criado_em'         =>  $this->criado_em,
                'atualizado_em'     =>  $this->atualizado_em
            ]);
        }*/
        

    }
?>