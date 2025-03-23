<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class EquipamentosQuantEntity{
        public $codigo_quantidade;
        public $codigo_funcionario;
        public $nome_funcionario;
        public $patente_funcionario;
        public $departamento;
        public $cargo; 
        public $documento_identidade; 
        public $celular_funcionario;  
        public $celular_alt; 
        public $fotografia; 
        public $codigo_equipamento;
        public $nome_equipamento;
        public $quantidade; 
        public $data_levantamento; 
        public $data_devolucao;
        public $estado_devolucao; 
        public $assinatura_levantamento; 
        public $assinatura_devolucao;
        public $criado_em;
        public $atualizado_em; 
        
        
        public  function cadastrar(){
            $this->codigo_quantidade = (new Database('quantidades_equipamentos'))->insert([
                'codigo_equipamento'                => $this->codigo_equipamento,
                'codigo_funcionario'                => $this->codigo_funcionario,
                'nome_funcionario'                  => $this->nome_funcionario,
                'patente_funcionario'               => $this->patente_funcionario,
                'departamento'                      => $this->departamento,
                'cargo'                             => $this->cargo,
                'documento_identidade'              => $this->documento_identidade,
                'celular_funcionario'               => $this->celular_funcionario,
                'celular_alt'                       => $this->celular_alt,
                'fotografia'                        => $this->fotografia,
                'nome_equipamento'                  => $this->nome_equipamento,
                'quantidade'                        => $this->quantidade,
                'data_levantamento'                 => $this->data_levantamento,
                'data_devolucao'                    => $this->data_devolucao,
                'estado_devolucao'                  => $this->estado_devolucao,
                'assinatura_levantamento'           => $this->assinatura_levantamento,
                'assinatura_devolucao'              => $this->assinatura_devolucao,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em
            ]);
            return $this->codigo_quantidade;
        }

        public static function getQuantities($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('quantidades_equipamentos'))->select($where, $order, $limit, $fields);
        }

        public static function getQuantitiesById($id){
            return self::getQuantities('codigo_quantidade = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('quantidades_equipamentos'))->update('codigo_quantidade = '.$this->codigo_quantidade, [
                'codigo_equipamento'                => $this->codigo_equipamento,
                'codigo_funcionario'                => $this->codigo_funcionario,
                'nome_funcionario'                  => $this->nome_funcionario,
                'patente_funcionario'               => $this->patente_funcionario,
                'departamento'                      => $this->departamento,
                'cargo'                             => $this->cargo,
                'documento_identidade'              => $this->documento_identidade,
                'celular_funcionario'               => $this->celular_funcionario,
                'celular_alt'                       => $this->celular_alt,
                'fotografia'                        => $this->fotografia,
                'nome_equipamento'                  => $this->nome_equipamento,
                'quantidade'                        => $this->quantidade,
                'data_levantamento'                 => $this->data_levantamento,
                'data_devolucao'                    => $this->data_devolucao,
                'estado_devolucao'                  => $this->estado_devolucao,
                'assinatura_levantamento'           => $this->assinatura_levantamento,
                'assinatura_devolucao'              => $this->assinatura_devolucao,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em
            ]);
        }

    }
?>