<?php
    namespace App\Controller\Api;
    use App\Model\Entity\StatusArmamentoEntity;
    use App\Model\Entity\WeaponEntity;

    class ArmamentoApiController extends Api{
        public static function getArmamentos($request) {
            $itens = [];

            $results = WeaponEntity::getWeapons(null, 'codigo_armamento DESC', null);

            while ($objWeapons = $results->fetchObject(WeaponEntity::class)) {
                $objStatus = StatusArmamentoEntity::getStatusById($objWeapons->codigo_armamento);
                $itens[] = [
                    'id'                => $objWeapons->codigo_armamento,
                    'name'              => $objWeapons->nome_armamento,
                    'numero_serie'      => $objWeapons->numero_serie,
                    'tipo'              => $objWeapons->nome_armamento,
                    'estado'            => $objWeapons->status_operacional,
                    'estado_desc'       => $objStatus->status,
                    'calibre'           => $objWeapons->calibre,
                    'data_inspensao'    => $objWeapons->data_ultima_inspecao,
                ];
            }
        
            return $itens;
        }
    }
?>