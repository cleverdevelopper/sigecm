<?php
    namespace App\Controller\Dashboard;
    use App\Controller\GlobalPageController;
    use App\Utils\ViewManager;
    use App\Model\Entity\SenhaConfig as EntitySenha;
    use App\Controller\Dashboard\Alert;
    use App\DatabaseManager\Pagination;
    use DateTime;
    use DateTimeZone;

    class PasswordConfigController extends GlobalPageController{
        private static function getPasswordItens($request, &$objPagination){
            $itens = '';
            $quantidadeTotal = EntitySenha::getSenhaConfig(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            $queryParams = $request->getQueryParams();
            $paginaActual = $queryParams['page'] ?? 1;

            $objPagination = new Pagination($quantidadeTotal, $paginaActual, 8);

            $results = EntitySenha::getSenhaConfig(null, 'codigo_senha_reset', $objPagination->getLimit());

            While ($objPassReset = $results->fetchObject(EntitySenha::class)){
                $itens .=ViewManager::render('dashboard/modules/configurations/itens', [
                    'id'            => $objPassReset->codigo_senha_reset,
                    'descricao'     => $objPassReset->descricao,
                    'senha'         => $objPassReset->palavra_passe,
                    'state'         => 'accoes'
                ]);
            }
            return $itens;
        }


        public static function getPasswordResetPage($request){
            $content = ViewManager::render('dashboard/modules/configurations/passwordConfig', [
                'navbar'            => parent::getNavbar(),
                'sidebar'           => parent::getMenu(),
                'rightsidebar'      => parent::getRightSidebar(),
                'footer'            => parent::getFooter(),
                'itens'             => self::getPasswordItens($request, $objPagination),
                'status'            => self::getStatus($request),
            ]);

            return parent::getPage('SIGECM | Configuracoes', $content);
        }

        public static function setPasswordResetPage($request){
            # Busca a senha de reset
            $postVars = $request->getPostVars();
            $objSenhaConfig = EntitySenha::getSenhaConfigById(1);

            $date = new DateTime('now', new DateTimeZone('Africa/Maputo')); 
            $formattedDate = $date->format('Y-m-d H:i:s');

            if($objSenhaConfig->codigo_senha_reset == ""){
                if($postVars['text_password'] != $postVars['text_password_repeat']){
                    $request->getRouter()->redirect('/settings?status=error');
                }else{
                    $objSenhaConfig = new EntitySenha;
                    $objSenhaConfig->descricao     = $postVars['text_description']; 
                    $objSenhaConfig->palavra_passe = $postVars['text_password'];
                    $objSenhaConfig->criado_em     = $formattedDate;
                    $objSenhaConfig->atualizado_em = $formattedDate;

                    $objSenhaConfig->cadastrar();
                    $request->getRouter()->redirect('/settings?status=created');
                }
            }elseif($objSenhaConfig->codigo_senha_reset == 1){
                if($postVars['text_password'] != $postVars['text_password_repeat']){
                    $request->getRouter()->redirect('/settings?status=error');
                }else{
                    $objSenhaConfig = new EntitySenha;
                    $objSenhaConfig->descricao     = $postVars['text_description']; 
                    $objSenhaConfig->palavra_passe = $postVars['text_password'];
                    $objSenhaConfig->atualizado_em = $formattedDate;

                    $objSenhaConfig->actualizar();
                    $request->getRouter()->redirect('/settings?status=updated');
                }
            }
        }



        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            if(!isset($queryParams['status'])) return '';
            switch($queryParams['status']){
                case 'created':
                    return Alert::getSuccess('Senha de reset cadastrado com sucesso.');
                    break;
                case 'updated':
                    return Alert::getSuccess('Senha de reset actualizada com sucesso.');
                    break;
                case 'deleted':
                    return Alert::getSuccess('Senha de reset excluido com sucesso.');
                    break;
                case 'error':
                    return Alert::getError('As senhas nao correspondem.');
                    break;
            }
        }
    }
?>