<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class WeaponEntity{
        public $codigo_armamento;
        public $codigo_tipo_armamento;
        public $nome_armamento;
        public $numero_serie;
        public $marca; 
        public $modelo; 
        public $calibre; 
        public $peso; 
        public $local_armazenamento; 
        public $status_operacional;
        public $disponibilidade; 
        public $data_aquisicao; 
        public $data_ultima_inspecao; 
        public $data_ultimo_uso; 
        public $responsavel_atual; 
        public $observacoes; 
        public $cadastrado_por; 
        public $criado_em;
        public $atualizado_em;  
        
        
        public  function cadastrar(){
            $this->codigo_armamento = (new Database('armamento'))->insert([
                'codigo_tipo_armamento'     => $this->codigo_tipo_armamento,
                'nome_armamento'            => $this->nome_armamento,
                'numero_serie'              => $this->numero_serie,
                'marca'                     => $this->marca,
                'modelo'                    => $this->modelo,
                'calibre'                   => $this->calibre,
                'peso'                      => $this->peso,
                'local_armazenamento'       => $this->local_armazenamento,
                'status_operacional'        => $this->status_operacional,
                'disponibilidade'           => $this->disponibilidade,
                'data_aquisicao'            => $this->data_aquisicao,
                'data_ultima_inspecao'      => $this->data_ultima_inspecao,
                'data_ultimo_uso'           => $this->data_ultimo_uso,
                'responsavel_atual'         => $this->responsavel_atual,
                'observacoes'               => $this->observacoes,
                'cadastrado_por'            => $this->cadastrado_por,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
            return $this->codigo_armamento;
        }

        public static function getWeapons($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('armamento'))->select($where, $order, $limit, $fields);
        }

        public static function getWeaponById($id){
            return self::getWeapons('codigo_armamento = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('armamento'))->update('codigo_armamento = '.$this->codigo_armamento, [
                'codigo_tipo_armamento'     => $this->codigo_tipo_armamento,
                'nome_armamento'            => $this->nome_armamento,
                'numero_serie'              => $this->numero_serie,
                'marca'                     => $this->marca,
                'modelo'                    => $this->modelo,
                'calibre'                   => $this->calibre,
                'peso'                      => $this->peso,
                'local_armazenamento'       => $this->local_armazenamento,
                'status_operacional'        => $this->status_operacional,
                'disponibilidade'           => $this->disponibilidade,
                'data_aquisicao'            => $this->data_aquisicao,
                'data_ultima_inspecao'      => $this->data_ultima_inspecao,
                'data_ultimo_uso'           => $this->data_ultimo_uso,
                'responsavel_atual'         => $this->responsavel_atual,
                'observacoes'               => $this->observacoes,
                'cadastrado_por'            => $this->cadastrado_por,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
        }

    }
?>