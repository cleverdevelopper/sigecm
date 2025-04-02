<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class ArrecadacaoRegisterEntity{
        public $codigo_arrecadacao;
        public $nome_funcionario;
        public $patente_funcionario;
        public $subunidade;
        public $celular_funcionario;  
        public $codigo_armamento; 
        public $numero_de_serie_arma; 
        public $tipo_armamento; 
        public $status_operacional_arma; 
        public $calibre_municao_arma; 
        public $data_ultima_inspecao_arma;  
        public $codigo_municao; 
        public $quantidade_municao; 
        public $condigo_carregador; 
        public $quantidade_carregador; 
        public $codigo_cartucheira; 
        public $quantidade_cartucheira; 
        public $quantidade_municao_devolucao; 
        public $data_levantamento;
        public $data_devolucao;
        public $assinatura_arrecadacao;
        public $assinatura_devolucao;
        public $assinatura_fiel;
        public $criado_em;
        public $atualizado_em;   
        public $apagado_em;
        
        public  function cadastrar(){
            $this->codigo_arrecadacao = (new Database('arrecadacao_armamento'))->insert([
                'nome_funcionario'                  => $this->nome_funcionario,
                'patente_funcionario'               => $this->patente_funcionario,
                'subunidade'                        => $this->subunidade,
                'celular_funcionario'               => $this->celular_funcionario,
                'codigo_armamento'                  => $this->codigo_armamento,
                'numero_de_serie_arma'              => $this->numero_de_serie_arma,
                'tipo_armamento'                    => $this->tipo_armamento,
                'status_operacional_arma'           => $this->status_operacional_arma,
                'calibre_municao_arma'              => $this->calibre_municao_arma,
                'data_ultima_inspecao_arma'         => $this->data_ultima_inspecao_arma,
                'codigo_municao'                    => $this->codigo_municao,
                'quantidade_municao'                => $this->quantidade_municao,
                'condigo_carregador'                => $this->condigo_carregador,
                'quantidade_carregador'             => $this->quantidade_carregador,
                'codigo_cartucheira'                => $this->codigo_cartucheira,
                'quantidade_cartucheira'            => $this->quantidade_cartucheira,
                'quantidade_municao_devolucao'      => $this->quantidade_municao_devolucao,
                'data_levantamento'                 => $this->data_levantamento,
                'data_devolucao'                    => $this->data_devolucao,
                'assinatura_arrecadacao'            => $this->assinatura_arrecadacao,
                'assinatura_devolucao'              => $this->assinatura_devolucao,
                'assinatura_fiel'                   => $this->assinatura_fiel,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em
            ]);
            return $this->codigo_arrecadacao;
        }

        public static function getArrecadacao($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('arrecadacao_armamento'))->select($where, $order, $limit, $fields);
        }

        public static function getArrecadacaoById($id){
            return self::getArrecadacao('codigo_arrecadacao = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('arrecadacao_armamento'))->update('codigo_arrecadacao = '.$this->codigo_arrecadacao, [
                'quantidade_municao_devolucao'      => $this->quantidade_municao_devolucao,
                'data_devolucao'                    => $this->data_devolucao,
                'assinatura_arrecadacao'            => $this->assinatura_arrecadacao,
                'assinatura_devolucao'              => $this->assinatura_devolucao,
                'assinatura_fiel'                   => $this->assinatura_fiel,
                'atualizado_em'                     => $this->atualizado_em
            ]);
        }

    }
?>