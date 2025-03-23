<?php
    namespace App\Controller\Dashboard;
    use App\Controller\Dashboard\DashboardPageController;
    use App\Utils\ViewManager;

    class BoxController extends DashboardPageController{
        private static function getFarmacia(){
            $itens = '';
            
            $itens = ViewManager::render('dashboard/modules/pacientes/itens', [
                'id'    => $objPaciente->codigo_paciente,
                'nome'  => $objPaciente->nome_paciente,
                'sexo'  => $objPaciente->genero,
            ]);   
            return $itens;
        }



        public static function getGrupos($request){
            $content = ViewManager::render('dashboard/modules/grupos/grupos',[
                'itens'         => self::getGruposItens($request, $objPagination),
                'pagination'    => parent::getPagination($request, $objPagination),
                'status'        => self::getStatus($request)
            ]);

            return parent::getPainel('Centro-medico - Grupos', $content);
        } 
    }

?>