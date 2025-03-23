<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class WeaponTypeEntity{
        public $codigo_tipo_armamento;
        public $classificacao;
        public $tipo_armamento;
        public $tipo_uso;
        public $potencia;
        public $alcance_eficaz;
        public $tipo_municao;
        public $calibre_municao;
		public $pais_origem;
        public $finalidade;
        public $categoria_perigo;
        public $descricao;
        public $criado_em;
        public $atualizado_em;
        public $apagado_em;


        public  function cadastrar(){
            $this->codigo_tipo_armamento = (new Database('tipos_armamentos'))->insert([
                'classificacao'                     => $this->classificacao,
                'tipo_armamento'                    => $this->tipo_armamento,
                'tipo_uso'                          => $this->tipo_uso,
                'potencia'                          => $this->potencia,
                'alcance_eficaz'                    => $this->alcance_eficaz,
                'tipo_municao'                      => $this->tipo_municao,
                'calibre_municao'                   => $this->calibre_municao,
                'pais_origem'                       => $this->pais_origem,
                'finalidade'                        => $this->finalidade,
                'categoria_perigo'                  => $this->categoria_perigo,
                'descricao'                         => $this->descricao,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em,
                'apagado_em'                        => $this->apagado_em,
            ]);
            return true;
        }

        public static function getWeaponTypes($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('tipos_armamentos'))->select($where, $order, $limit, $fields);
        }

        public static function getweaponTypeById($id){
            return self::getWeaponTypes('codigo_tipo_armamento = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('tipos_armamentos'))->update('codigo_tipo_armamento = '.$this->codigo_tipo_armamento, [
                'classificacao'                     => $this->classificacao,
                'tipo_armamento'                    => $this->tipo_armamento,
                'tipo_uso'                          => $this->tipo_uso,
                'potencia'                          => $this->potencia,
                'alcance_eficaz'                    => $this->alcance_eficaz,
                'tipo_municao'                      => $this->tipo_municao,
                'calibre_municao'                   => $this->calibre_municao,
                'pais_origem'                       => $this->pais_origem,
                'finalidade'                        => $this->finalidade,
                'categoria_perigo'                  => $this->categoria_perigo,
                'descricao'                         => $this->descricao,
                'criado_em'                         => $this->criado_em,
                'atualizado_em'                     => $this->atualizado_em,
                'apagado_em'                        => $this->apagado_em,
            ]);
        }

    }
?>