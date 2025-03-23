<?php
    namespace App\Controller\Api;
    use App\Model\Entity\FuncionarioEntity;

    class FuncionariosApiController extends Api{
        public static function getFuncionarios($request) {
            $itens = [];

            $results = FuncionarioEntity::getFuncionario(null, 'codigo_funcionario DESC', null);

            while ($objFuncionario = $results->fetchObject(FuncionarioEntity::class)) {
                $itens[] = [
                    'id'            => $objFuncionario->codigo_funcionario,
                    'name'          => $objFuncionario->nome_completo,
                    'genero'        => $objFuncionario->genero,
                    'patente'       => $objFuncionario->patente,
                    'cargo'         => $objFuncionario->cargo,
                    'documento'     => $objFuncionario->documento_identidade,
                    'departamento'  => $objFuncionario->nome_departamento,
                    'celular'       => $objFuncionario->celular,
                    'celular_alt'   => $objFuncionario->celular_alt,
                    'fotografia'    => $objFuncionario->fotografia,
                    'criado_em'     => $objFuncionario->criado_em
                ];
            }
        
            return $itens;
        }
    }
?>