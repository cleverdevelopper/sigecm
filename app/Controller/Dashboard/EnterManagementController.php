<?php
    namespace App\Controller\Dashboard;;
    use App\Utils\ViewManager;
    use App\Controller\Dashboard\ErrorController;
    use App\Controller\GlobalPageController;
    use App\Model\Entity\DepartamentoEntity;
    use App\Model\Entity\EnterManagementEntity;
    use App\Model\Entity\GuestEntity;
    use App\Utils\Funcoes;
    use DateTime;
    use DateTimeZone;

    class EnterManagementController extends GlobalPageController{
        #=========================================================
        # Funcoes responsaveis por cadastrar visitante e registar
        # uma entrada
        #=========================================================
        public static function setGuest($request){
            if(Funcoes::Permition(6)){
                #busca o nome da imagem para armazenar na base de dados
                $file = $request->getFile();
                $postVars = $request->getPostVars();
                $codigoVisitante = (int) $postVars['text_codigo_visitante'];

                #======================================================
                # renderiza a data 
                #======================================================
                $date = new DateTime('now', new DateTimeZone('Africa/Maputo')); 
                $formattedDate = $date->format('Y-m-d H:i:s');

                #=======================================================
                # caso o visitante ja esteja cadastrado
                # o sistema apenas cadastra a tabela entradas
                #=======================================================
                if($codigoVisitante != 0){
                    $objEntrada = new EnterManagementEntity;
                    $objEntrada->codigo_visitante               = $codigoVisitante;
                    $objEntrada->codigo_atendente               = $_SESSION['admin']['utilizador']['id'];
                    $objEntrada->nome_atendente                 = $_SESSION['admin']['utilizador']['nome_utilizador'];
                    $objEntrada->nome_completo                  = $postVars['text_nomecompleto'];
                    $objEntrada->visitado                       = $postVars['text_visitado'];
                    $objEntrada->sector_visitado                = $postVars['departamento'];
                    $objEntrada->celular                        = $postVars['text_celular'];
                    $objEntrada->celular_alternativo            = $postVars['text_celular_alt'];
                    $objEntrada->portador_viatura               = $postVars['text_viatura'];
                    $objEntrada->portador_arma                  = $postVars['text_arma'];
                    $objEntrada->obs_pertinentes                = $postVars['text_obs'];
                    $objEntrada->data_entrada                   = $formattedDate;
                    $objEntrada->criado_em                      = $formattedDate;
                    $objEntrada->atualizado_em                  = $formattedDate;

                    $objEntrada->cadastrar();

                    $request->getRouter()->redirect('/visitors?status=created');
                }else{
                    #=======================================================
                    # caso o visitante nao esteja cadastrado
                    # o sistema deve cadastra-lo e cadastrar aentrada
                    #=======================================================
                    $objVisitante = new GuestEntity;
                    $objVisitante->nome_completo                = $postVars['text_nomecompleto'];   
                    $objVisitante->imagem                       = $file;   
                    $objVisitante->criado_em                    = date('Y-m-d H:i:s');   
                    $objVisitante->atualizado_em                = date('Y-m-d H:i:s'); 
                    
                    $codigo_novo_visitante = $objVisitante->cadastrar();
                    
                    if ($codigo_novo_visitante != null){
                        $objEntrada = new EnterManagementEntity;
                        $objEntrada->codigo_visitante               = $codigo_novo_visitante;
                        $objEntrada->codigo_atendente               = $_SESSION['admin']['utilizador']['id'];
                        $objEntrada->nome_atendente                 = $_SESSION['admin']['utilizador']['nome_utilizador'];
                        $objEntrada->nome_completo                  = $postVars['text_nomecompleto'];
                        $objEntrada->visitado                       = $postVars['text_visitado'] || 'Ninguem especificado';
                        $objEntrada->sector_visitado                = $postVars['departamento'];
                        $objEntrada->celular                        = $postVars['text_celular'];
                        $objEntrada->celular_alternativo            = $postVars['text_celular_alt'];
                        $objEntrada->portador_viatura               = $postVars['text_viatura'];
                        $objEntrada->portador_arma                  = $postVars['text_arma'];
                        $objEntrada->obs_pertinentes                = $postVars['text_obs'];
                        $objEntrada->data_entrada                   = $formattedDate;
                        $objEntrada->criado_em                      = $formattedDate;
                        $objEntrada->atualizado_em                  = $formattedDate;
    
                        $objEntrada->cadastrar();
    
                        $request->getRouter()->redirect('/visitors?status=created'); 
                    };
                }
            }
        }
        #=========================================================
        # FIM das funcoes de registro
        #=========================================================
        
        #=========================================================
        # Funcao responsavel por imprimir as entradas sem saidas
        #=========================================================
        private static function getEntradasItens($request){
            $itens = '';
            $where = 'data_saida IS NULL';
            $results = EnterManagementEntity::getMovimentacoes($where, 'codigo_movimentacoes DESC', null);
            While ($objEntradas = $results->fetchObject(EnterManagementEntity::class)){
                $date = new DateTime($objEntradas->data_entrada, new DateTimeZone('UTC'));

                $fmtDate = new \IntlDateFormatter(
                    'pt_MZ', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, null, \IntlDateFormatter::GREGORIAN
                );

                $fmtTime = new \IntlDateFormatter(
                    'pt_MZ', \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT,null, \IntlDateFormatter::GREGORIAN 
                );

                $formattedDate = $fmtDate->format($date); 
                $formattedTime = $fmtTime->format($date);

                $formattedDateTime = $formattedDate . ' às ' . $formattedTime;
        
                $itens .= ViewManager::render('dashboard/modules/entermanagement/visitorsItem', [
                    'codigo'                => $objEntradas->codigo_movimentacoes,
                    'nome_completo'         => $objEntradas->nome_completo,
                    'data_entrada'          => $formattedDateTime,
                    'sector'                => $objEntradas->sector_visitado,
                    'pessoa'                => $objEntradas->visitado,
                    'viatura'               => $objEntradas->portador_viatura,
                    'arma'                  => $objEntradas->portador_arma,
                ]);
            }
            return $itens;
        }
        

        public static function getVisitorsPage($request){
            if(Funcoes::Permition(6)){
                $content = ViewManager::render('dashboard/modules/entermanagement/visitors', [
                    'navbar'            => parent::getNavbar(),
                    'sidebar'           => parent::getMenu(),
                    'rightsidebar'      => parent::getRightSidebar(),
                    'footer'            => parent::getFooter(),
                    'vistorsItem'       => self:: getEntradasItens($request),
                ]);
        
                return parent::getPage('SIGECM | Entradas', $content);
            } else {
                return ErrorController::getError($request);
            }
        }
        #=========================================================
        # Fim imprimir as entradas sem saidas
        #=========================================================

        #=========================================================
        # Funcoes de gestao de saidas
        #=========================================================
        public static function setExitGuest($request){
            if(Funcoes::Permition(7)){
                $postVars = $request->getPostVars();
                $codigoMovimentacao = (int) $postVars['text_codigo'];

                #======================================================
                # renderiza a data 
                #======================================================
                $date = new DateTime('now', new DateTimeZone('Africa/Maputo')); 
                $formattedDate = $date->format('Y-m-d H:i:s');

                $objMovimentacoes = EnterManagementEntity::getMovimentacoesById($codigoMovimentacao);
            
                if(!$objMovimentacoes instanceof EnterManagementEntity){
                    $request->getRouter()->redirect('/exitregister');
                }

                $objMovimentacoes->data_saida           = $formattedDate;
                $objMovimentacoes->atualizado_em        = $formattedDate;

                $objMovimentacoes->actualizar();

                $request->getRouter()->redirect('/exitregister?status=updated');
            }else{
                return ErrorController::getError($request);
            }
        }


        private static function getEntradasExitItens($request){
            $itens = '';
            $where = 'data_saida IS NULL';
            $results = EnterManagementEntity::getMovimentacoes($where, 'codigo_movimentacoes DESC', null);
            While ($objEntradas = $results->fetchObject(EnterManagementEntity::class)){
                $date = new DateTime($objEntradas->data_entrada, new DateTimeZone('UTC'));

                $fmtDate = new \IntlDateFormatter(
                    'pt_MZ', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, null, \IntlDateFormatter::GREGORIAN
                );

                $fmtTime = new \IntlDateFormatter(
                    'pt_MZ', \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT,null, \IntlDateFormatter::GREGORIAN 
                );

                $formattedDate = $fmtDate->format($date); 
                $formattedTime = $fmtTime->format($date);

                $formattedDateTime = $formattedDate . ' às ' . $formattedTime;
        
                // Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/entermanagement/exitsItem', [
                    'codigo'                => $objEntradas->codigo_movimentacoes,
                    'nome_completo'         => $objEntradas->nome_completo,
                    'data_entrada'          => $formattedDateTime,
                    'sector'                => $objEntradas->sector_visitado,
                    'pessoa'                => $objEntradas->visitado,
                    'processor'             => $objEntradas->nome_atendente,
                ]);
            }
            return $itens;
        }
        

        public static function getExitsPage($request){
            if(Funcoes::Permition(7)){
                $content = ViewManager::render('dashboard/modules/entermanagement/exits', [
                    'navbar'            => parent::getNavbar(),
                    'sidebar'           => parent::getMenu(),
                    'rightsidebar'      => parent::getRightSidebar(),
                    'footer'            => parent::getFooter(),
                    'ExitsItem'         => self::getEntradasExitItens($request),
                ]);
        
                return parent::getPage('SIGECM | Gestao de Saidas', $content);
            } else {
                return ErrorController::getError($request);
            }
        }
        #=========================================================
        # Fim das Funcoes de gestao de saidas
        #=========================================================

        #=========================================================
        # Funcao responsavel por gerar relatorios
        #=========================================================
        private static function getEntradasInfoItens($request){
            $itens = '';
            $where = 'data_saida IS NOT NULL';
            $results = EnterManagementEntity::getMovimentacoes($where, 'codigo_movimentacoes DESC', null);
            While ($objEntradas = $results->fetchObject(EnterManagementEntity::class)){
                $itens .= ViewManager::render('dashboard/modules/entermanagement/reportsItem', [
                    'codigo'                => $objEntradas->codigo_movimentacoes,
                    'nome_completo'         => $objEntradas->nome_completo,
                    'data_entrada'          => $objEntradas->data_entrada,
                    'sector'                => $objEntradas->sector_visitado,
                    'pessoa'                => $objEntradas->visitado,
                    'viatura'               => $objEntradas->portador_viatura,
                    'arma'                  => $objEntradas->portador_arma,
                    'data_saida'            => $objEntradas->data_saida,
                ]);
            }
            return $itens;
        }


        public static function getReportsPage($request){
            if(Funcoes::Permition(8)){
                $content = ViewManager::render('dashboard/modules/entermanagement/reports', [
                    'navbar'            => parent::getNavbar(),
                    'sidebar'           => parent::getMenu(),
                    'rightsidebar'      => parent::getRightSidebar(),
                    'footer'            => parent::getFooter(),
                    'reportsItem'         => self::getEntradasInfoItens($request),
                ]);
        
                return parent::getPage('SIGECM | Relatorios Entadas e Saidas', $content);
            } else {
                return ErrorController::getError($request);
            }
        }
        #=========================================================
        # Fim da Funcao responsavel por gerar relatorios
        #=========================================================

        #=========================================================
        # Busca a pagina inicial Dos visitantes
        #=========================================================
        #Busca o sector da base de dados para mostrar no frontend
        private static function getDepartamentoItens($request){
            $itens = '';
            $results = DepartamentoEntity::getDepartamentos(null, 'codigo_departamento', null);
            While ($objDepartamento = $results->fetchObject(DepartamentoEntity::class)){
                $itens .=ViewManager::render('dashboard/modules/entermanagement/departmentItem', [
                    'departamento_id'       => $objDepartamento->codigo_departamento,
                    'departamento'          => $objDepartamento->nome_departamento
                ]);
            }
            return $itens;
        }

        public static function getEnterPage($request){
            date_default_timezone_set('Africa/Maputo'); 
            if (setlocale(LC_TIME, 0) === false) {
                return ErrorController::getError($request, 'Erro na configuração de localidade');
            }
        
            if(Funcoes::Permition(6)){
                $date = new DateTime('now', new DateTimeZone('Africa/Maputo')); 
                $fmt = new \IntlDateFormatter(
                    'pt_MZ',
                    \IntlDateFormatter::LONG, // Formato longo (ex: 1 de Janeiro de 2025)
                    \IntlDateFormatter::SHORT, // Formato de hora curto (ex: 14:30)
                    null, // Fuso horário (usando o fuso horário definido anteriormente)
                    \IntlDateFormatter::GREGORIAN // Calendário Gregoriano
                );
        
                $formattedDate = $fmt->format($date);
                $content = ViewManager::render('dashboard/modules/entermanagement/enter', [
                    'navbar'            => parent::getNavbar(),
                    'sidebar'           => parent::getMenu(),
                    'rightsidebar'      => parent::getRightSidebar(),
                    'footer'            => parent::getFooter(),
                    'date'              => $formattedDate, // Data formatada
                    'departamentoItem'  => self::getDepartamentoItens($request)
                ]);
        
                return parent::getPage('SIGECM | Entradas', $content);
            } else {
                return ErrorController::getError($request);
            }
        }
        


    }
?>