<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class EnterManagementEntity{
        public $codigo_movimentacoes;
        public $codigo_visitante;
        public $codigo_atendente;
        public $nome_atendente;
        public $nome_completo;
        public $visitado;
        public $sector_visitado;
        public $celular;
		public $celular_alternativo;
        public $portador_viatura;
        public $portador_arma;
        public $obs_pertinentes;
        public $data_entrada;
        public $data_saida;
        public $criado_em;
        public $atualizado_em;
        public $apagado_em;

        public  function cadastrar(){
            $this->codigo_movimentacoes = (new Database('movimentacoes'))->insert([
                'codigo_visitante'                  => $this->codigo_visitante,
                'codigo_atendente'                  => $this->codigo_atendente,
                'nome_atendente'                    => $this->nome_atendente,
                'nome_completo'                     => $this->nome_completo,
                'visitado'                          => $this->visitado,
                'sector_visitado'                   => $this->sector_visitado,
                'celular'                           => $this->celular,
                'celular_alternativo'               => $this->celular_alternativo,
                'portador_viatura'                  => $this->portador_viatura,
                'portador_arma'                     => $this->portador_arma,
                'obs_pertinentes'                   => $this->obs_pertinentes,
                'data_entrada'                      => $this->data_entrada,
                'data_saida'                        => $this->data_saida,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em,
                'apagado_em'                        => $this->apagado_em,
            ]);
            return true;
        }

        public static function getMovimentacoes($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('movimentacoes'))->select($where, $order, $limit, $fields);
        }

        public static function getMovimentacoesById($id){
            return self::getMovimentacoes('codigo_movimentacoes = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('movimentacoes'))->update('codigo_movimentacoes = '.$this->codigo_movimentacoes, [
                'codigo_visitante'                  => $this->codigo_visitante,
                'codigo_atendente'                  => $this->codigo_atendente,
                'nome_atendente'                    => $this->nome_atendente,
                'nome_completo'                     => $this->nome_completo,
                'visitado'                          => $this->visitado,
                'sector_visitado'                   => $this->sector_visitado,
                'celular'                           => $this->celular,
                'celular_alternativo'               => $this->celular_alternativo,
                'portador_viatura'                  => $this->portador_viatura,
                'portador_arma'                     => $this->portador_arma,
                'obs_pertinentes'                   => $this->obs_pertinentes,
                'data_entrada'                      => $this->data_entrada,
                'data_saida'                        => $this->data_saida,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em,
                'apagado_em'                        => $this->apagado_em,
            ]);
        }

    }
?>