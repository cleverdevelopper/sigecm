<?php
    namespace App\Controller\Api;
    use App\Model\Entity\GuestEntity;

    class GuestApiController extends Api{
        public static function getGuestByImage($request, $image) {

            $objGuest = GuestEntity::getGuestByImage($image);

            if(!$objGuest instanceof GuestEntity){
                throw new \Exception('O Visitante '.$image.' não foi encontrado!', 404 );
            }
            return [
                'id'            => $objGuest->codigo_visitante,
                'name'          => $objGuest->nome_completo,
                'criado_em'     => $objGuest->criado_em
            ];
        }

    }
?>