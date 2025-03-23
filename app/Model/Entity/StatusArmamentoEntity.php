<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class StatusArmamentoEntity{
        public $codigo_status;
        public $status;        


        public  function cadastrar(){
            $this->codigo_status = (new Database('status_operacional_armamento'))->insert([
                'status'     =>  $this->status
            ]);
            return true;
        }

        public static function getStatus($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('status_operacional_armamento'))->select($where, $order, $limit, $fields);
        }

        public static function getStatusById($id){
            return self::getStatus('codigo_status = '.$id)->fetchObject(self::class);
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