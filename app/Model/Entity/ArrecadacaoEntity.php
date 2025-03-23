<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class ArrecadacaoEntity{
        public $codigo_arrecadacao;
        public $codigo_funcionario;
        public $nome_funcionario;
        public $patente_funcionario;
        public $departamento;
        public $cargo; 
        public $documento_identidade; 
        public $celular_funcionario;  
        public $celular_alt; 
        public $fotografia; 
        public $codigo_armamento; 
        public $numero_de_serie_arma; 
        public $tipo_armamento; 
        public $status_operacional_arma; 
        public $calibre_municao_arma; 
        public $data_ultima_inspecao_arma;  
        public $codigo_municao; 
        public $quantidade_municao; 
        public $quantidade_municao_devolucao; 
        public $data_levantamento;
        public $data_devolucao;
        public $assinatura_arrecadacao;
        public $assinatura_devolucao;
        public $assinatura_fiel;
        public $criado_em;
        public $atualizado_em;   
        
        
        public  function cadastrar(){
            $this->codigo_arrecadacao = (new Database('arrecadacao'))->insert([
                'codigo_funcionario'                => $this->codigo_funcionario,
                'nome_funcionario'                  => $this->nome_funcionario,
                'patente_funcionario'               => $this->patente_funcionario,
                'departamento'                      => $this->departamento,
                'cargo'                             => $this->cargo,
                'documento_identidade'              => $this->documento_identidade,
                'celular_funcionario'               => $this->celular_funcionario,
                'celular_alt'                       => $this->celular_alt,
                'fotografia'                        => $this->fotografia,
                'codigo_armamento'                  => $this->codigo_armamento,
                'numero_de_serie_arma'              => $this->numero_de_serie_arma,
                'tipo_armamento'                    => $this->tipo_armamento,
                'status_operacional_arma'           => $this->status_operacional_arma,
                'calibre_municao_arma'              => $this->calibre_municao_arma,
                'data_ultima_inspecao_arma'         => $this->data_ultima_inspecao_arma,
                'codigo_municao'                    => $this->codigo_municao,
                'quantidade_municao'                => $this->quantidade_municao,
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
            return (new Database('arrecadacao'))->select($where, $order, $limit, $fields);
        }

        public static function getArrecadacaoById($id){
            return self::getArrecadacao('codigo_arrecadacao = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('arrecadacao'))->update('codigo_arrecadacao = '.$this->codigo_arrecadacao, [
                'codigo_funcionario'                => $this->codigo_funcionario,
                'nome_funcionario'                  => $this->nome_funcionario,
                'patente_funcionario'               => $this->patente_funcionario,
                'departamento'                      => $this->departamento,
                'cargo'                             => $this->cargo,
                'documento_identidade'              => $this->documento_identidade,
                'celular_funcionario'               => $this->celular_funcionario,
                'celular_alt'                       => $this->celular_alt,
                'fotografia'                        => $this->fotografia,
                'codigo_armamento'                  => $this->codigo_armamento,
                'numero_de_serie_arma'              => $this->numero_de_serie_arma,
                'tipo_armamento'                    => $this->tipo_armamento,
                'status_operacional_arma'           => $this->status_operacional_arma,
                'calibre_municao_arma'              => $this->calibre_municao_arma,
                'data_ultima_inspecao_arma'         => $this->data_ultima_inspecao_arma,
                'codigo_municao'                    => $this->codigo_municao,
                'quantidade_municao'                => $this->quantidade_municao,
                'quantidade_municao_devolucao'      => $this->quantidade_municao_devolucao,
                'data_levantamento'                 => $this->data_levantamento,
                'data_devolucao'                    => $this->data_devolucao,
                'assinatura_arrecadacao'            => $this->assinatura_arrecadacao,
                'assinatura_devolucao'              => $this->assinatura_devolucao,
                'assinatura_fiel'                   => $this->assinatura_fiel,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em
            ]);
        }

    }
?>