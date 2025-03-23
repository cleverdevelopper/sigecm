<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class EquipmentEntity{
        public $codigo_equipamento;
        public $tipo;
        public $nome;
        public $material;
        public $capacidade; 
        public $peso; 
        public $cor; 
        public $compatibilidade; 
        public $finalidade; 
        public $fabricante; 
        public $pais_origem; 
        public $data_fabricacao; 
        public $estado; 
        public $quantidade; 
        public $descricao; 
        public $criado_em;
        public $atualizado_em;  
        
        
        public  function cadastrar(){
            $this->codigo_equipamento = (new Database('equipamentos'))->insert([
                'tipo'                      => $this->tipo,
                'nome'                      => $this->nome,
                'material'                  => $this->material,
                'capacidade'                => $this->capacidade,
                'peso'                      => $this->peso,
                'cor'                       => $this->cor,
                'compatibilidade'           => $this->compatibilidade,
                'finalidade'                => $this->finalidade,
                'fabricante'                => $this->fabricante,
                'pais_origem'               => $this->pais_origem,
                'data_fabricacao'           => $this->data_fabricacao,
                'estado'                    => $this->estado,
                'quantidade'                => $this->quantidade,
                'descricao'                 => $this->descricao,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
            return $this->codigo_equipamento;
        }

        public static function getEquipments($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('equipamentos'))->select($where, $order, $limit, $fields);
        }

        public static function getEquipmentById($id){
            return self::getEquipments('codigo_equipamento = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('equipamentos'))->update('codigo_equipamento = '.$this->codigo_equipamento, [
                'tipo'                      => $this->tipo,
                'nome'                      => $this->nome,
                'material'                  => $this->material,
                'capacidade'                => $this->capacidade,
                'peso'                      => $this->peso,
                'cor'                       => $this->cor,
                'compatibilidade'           => $this->compatibilidade,
                'finalidade'                => $this->finalidade,
                'fabricante'                => $this->fabricante,
                'pais_origem'               => $this->pais_origem,
                'data_fabricacao'           => $this->data_fabricacao,
                'estado'                    => $this->estado,
                'quantidade'                => $this->quantidade,
                'descricao'                 => $this->descricao,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
        }

    }
?>