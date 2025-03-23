<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class AmmunitionEntity{
        public $codigo_municao;
        public $nome;
        public $calibre;
        public $tipo;
        public $peso; 
        public $velocidade_inicial; 
        public $capacidade_penetracao; 
        public $fabricante; 
        public $data_fabricacao; 
        public $quantidade_estoque; 
        public $arma_compativel; 
        public $observacoes; 
        public $criado_em;
        public $atualizado_em;  
        
        
        public  function cadastrar(){
            $this->codigo_municao = (new Database('municoes'))->insert([
                'nome'                      => $this->nome,
                'calibre'                   => $this->calibre,
                'tipo'                      => $this->tipo,
                'peso'                      => $this->peso,
                'velocidade_inicial'        => $this->velocidade_inicial,
                'capacidade_penetracao'     => $this->capacidade_penetracao,
                'fabricante'                => $this->fabricante,
                'data_fabricacao'           => $this->data_fabricacao,
                'quantidade_estoque'        => $this->quantidade_estoque,
                'arma_compativel'           => $this->arma_compativel,
                'observacoes'               => $this->observacoes,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
            return $this->codigo_municao;
        }

        public static function getAmmunition($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('municoes'))->select($where, $order, $limit, $fields);
        }

        public static function getWeaponById($id){
            return self::getAmmunition('codigo_municao = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('municoes'))->update('codigo_municao = '.$this->codigo_municao, [
                'nome'                      => $this->nome,
                'calibre'                   => $this->calibre,
                'tipo'                      => $this->tipo,
                'peso'                      => $this->peso,
                'velocidade_inicial'        => $this->velocidade_inicial,
                'capacidade_penetracao'     => $this->capacidade_penetracao,
                'fabricante'                => $this->fabricante,
                'data_fabricacao'           => $this->data_fabricacao,
                'quantidade_estoque'        => $this->quantidade_estoque,
                'arma_compativel'           => $this->arma_compativel,
                'observacoes'               => $this->observacoes,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
        }

    }
?>