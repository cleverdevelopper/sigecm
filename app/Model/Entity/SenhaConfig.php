<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class SenhaConfig{
        public $codigo_senha_reset;
        public $descricao;                
        public $palavra_passe;                        
        public $criado_em;  
        public $atualizado_em;      


        public  function cadastrar(){
            $this->codigo_senha_reset = (new Database('senha_config'))->insert([
                'palavra_passe'     =>  $this->palavra_passe,
                'descricao'         =>  $this->descricao,
                'criado_em'         =>  $this->criado_em,
                'atualizado_em'     =>  $this->atualizado_em
            ]);
            return true;
        }

        public static function getSenhaConfig($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('senha_config'))->select($where, $order, $limit, $fields);
        }

        public static function getSenhaConfigById($id){
            return self::getSenhaConfig('codigo_senha_reset = '.$id)->fetchObject(self::class);
        }

        /*public  function actualizar(){
            return (new Database('senha_config'))->update('codigo_senha_reset = '.$this->codigo_senha_reset, [
                'palavra_passe'     =>  $this->palavra_passe,
                'descricao'         =>  $this->descricao,
                'criado_em'         =>  $this->criado_em,
                'atualizado_em'     =>  $this->atualizado_em
            ]);
        }*/

        public function actualizar() {
            $values = [
                'palavra_passe'         => $this->palavra_passe,
                'descricao'             => $this->descricao,
                'criado_em'             => $this->criado_em,
                'atualizado_em'         => $this->atualizado_em,
                'apagado_em'            => null
            ];
        
            // Log the values array to make sure it's not empty
            error_log(print_r($values, true)); // Logs the array to PHP error log (or use var_dump)
        
            return (new Database('senha_config'))->update(
                'codigo_senha_reset = ?', array_merge(array_values($values), [$this->codigo_senha_reset])
            );
        }
        

    }
?>