<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class GuestEntity{
        public $codigo_visitante;
        public $nome_completo;
        public $imagem;
        public $criado_em;
        public $atualizado_em;  

        
        public  function cadastrar(){
            $this->codigo_visitante = (new Database('visitantes'))->insert([
                'nome_completo'       => $this->nome_completo,
                'imagem'              => $this->imagem,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
            return $this->codigo_visitante;
        }

        public static function getGuest($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('visitantes'))->select($where, $order, $limit, $fields);
        }

        public static function getGrupoById($id){
            return self::getGuest('codigo_visitante = '.$id)->fetchObject(self::class);
        }

        public static function getGuestByImage($image) {
            return self::getGuest('imagem = "'.$image.'"')->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('visitantes'))->update('codigo_visitante = '.$this->codigo_visitante, [
                'nome_completo'       => $this->nome_completo,
                'imagem'              => $this->imagem,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
        }

    }
?>