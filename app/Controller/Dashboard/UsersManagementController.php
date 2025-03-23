<?php
    namespace App\Controller\Dashboard;
    use App\Utils\ViewManager;
    use App\DatabaseManager\Pagination;
    use App\Model\Entity\LoginEntity\UtilizadorPermissoes as EntityUtilizador;
    use App\Controller\Dashboard\ErrorController;
    use App\Controller\GlobalPageController;
    use App\Utils\Funcoes;

    class UsersManagementController extends GlobalPageController{
        private static function getUtilizadorItens($request, &$objPagination){
            $itens = '';
            $quantidadeTotal = EntityUtilizador::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            $queryParams = $request->getQueryParams();
            $paginaActual = $queryParams['page'] ?? 1;

            $objPagination = new Pagination($quantidadeTotal, $paginaActual, 8);

            $results = EntityUtilizador::getUsers(null, 'codigo_utilizador', $objPagination->getLimit());

            While ($objUtilizador = $results->fetchObject(EntityUtilizador::class)){
                $itens .=ViewManager::render('dashboard/modules/usersmanagment/itens', [
                    'codigo'            => $objUtilizador->codigo_utilizador,
                    'user'              => $objUtilizador->utilizador,
                    'name'              => $objUtilizador->nome_utilizador,
                    'grupo'             => $objUtilizador->descricao_grupo,
                    'departamento'      =>  $objUtilizador->departamento 
                ]);
            }
            return $itens;
        }


        
        
        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            
            if(!isset($queryParams['status'])) return '';

            switch($queryParams['status']){
                case 'created':
                    return Alert::getSuccess('Utilizador cadastrado com sucesso.');
                    break;
                case 'updated':
                    return Alert::getSuccess('Utilizador actualizada com sucesso.');
                    break;
                case 'deleted':
                    return Alert::getSuccess('Utilizador excluido com sucesso.');
                    break;
            }
        } 
        
        public static function getUtilizadores($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/usersmanagment/users',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'itens'         => self::getUtilizadorItens($request, $objPagination),
                    'status'        => self::getStatus($request)
                ]);

                return parent::getPage('SIGECM | Utilizadores', $content);
            }else{
                return ErrorController::getError($request);
            }
        }

    }
?>