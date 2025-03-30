<?php
    namespace App\Controller\Dashboard;
    use App\Controller\GlobalPageController;
    use App\Utils\ViewManager;
    use App\Model\Entity\LoginEntity\UtilizadorPermissoes as EntityUtilizador;
    use App\Model\Entity\EnterManagementEntity;
    use App\Utils\Funcoes;

    class DashboardController extends GlobalPageController
    {

        #========================================================
        # Dados para apresentacao no painel de visitantes
        #========================================================
        private static function gerarPermissoes($posicaoInicial, $posicaoFinal, $tamanhoTotal = 100) {
            $permissoes = str_repeat('0', $tamanhoTotal);
            $posicaoFinal = min($posicaoFinal, $tamanhoTotal - 1);
            $permissoes = substr_replace($permissoes, str_repeat('1', $posicaoFinal - $posicaoInicial + 1), $posicaoInicial, $posicaoFinal - $posicaoInicial + 1);
            
            return $permissoes;
        }  

        private static function getUtilizadorItens($request){
            $itens = 0;
            $posicaoInicial = 5;  // Posição inicial (0-indexed)
            $posicaoFinal = 8;    // Posição final (0-indexed)

            $permissoes_finais = self::gerarPermissoes($posicaoInicial, $posicaoFinal);

            $results = EntityUtilizador::getUsers("permissoes = '" . $permissoes_finais . "'", null);
            While ($obJUsers = $results->fetchObject(EntityUtilizador::class)){
                $itens++;
            }
            return $itens;
        }
        #========================================================
        # Fim Dados para apresentacao no painel de visitantes
        #========================================================
        
        //Verificacacao das permissoes
        public static function getDashboard($request)
        {
            if (Funcoes::Permition(0)) {
                //$quantidadeTotal = EntityUtilizador::getUtilizadores(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

                $content = ViewManager::render('dashboard/painel', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    //'users'         => $quantidadeTotal,
                    //'designation'   => 'Utilizadores Activos' 
                ]);

                return parent::getPage('SIGECM | Painel Incial', $content);
            } elseif (Funcoes::Permition(5)) {

                #===========================================
                # informacao das entradas
                #===========================================
                $data_hoje = date('Y-m-d');
                $where = "data_saida IS NULL AND DATE(data_entrada) = '$data_hoje'";
                $quantidadeTotalEntradas = EnterManagementEntity::getMovimentacoes($where, 'codigo_movimentacoes DESC', null, 'COUNT(*) as qtd')->fetchObject()->qtd;

                #===========================================
                # informacao das Saidas
                #===========================================
                $where = "data_saida IS NOT NULL AND DATE(data_saida) = '$data_hoje'";
                $quantidadeTotalsaidas = EnterManagementEntity::getMovimentacoes($where, 'codigo_movimentacoes DESC', null, 'COUNT(*) as qtd')->fetchObject()->qtd;

                #===========================================
                # informacao das entras e saidas
                #===========================================
                $quantidadeTotal = EnterManagementEntity::getMovimentacoes(null, 'codigo_movimentacoes', null, 'COUNT(*) as qtd')->fetchObject()->qtd;
                $content = ViewManager::render('dashboard/painelVisitas', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'utilizadores'  => self::getUtilizadorItens($request),
                    'entradas'      => $quantidadeTotalEntradas,
                    'saidas'        => $quantidadeTotalsaidas,
                    'movimentacoes' => $quantidadeTotal,
                    //'designation'   => 'Utilizadores Activos'
                ]);
                return parent::getPage('SIGECM | Painel Incial', $content);
            }elseif(Funcoes::Permition(9)){
                $content = ViewManager::render('dashboard/painelArmamento',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'utilizadores'  => self::getUtilizadorItens($request),
                ]);
    
                return parent::getPage('SIGECM | Painel Incial', $content);
            }
            
            
            
            /*elseif(Funcoes::Permition(9)){
                        $quantidadeTotal = 188888;
                        $content = ViewManager::render('dashboard/modules/home/painelInicial',[
                            'navbar'        => parent::getNavbar(),
                            'users'         => $quantidadeTotal,
                            'designation'   => 'Medicamentos Cadastrados'
                        ]);
            
                        return parent::getPainel('Centro-medico - Painel Inicial', $content);
                    }*/ else {
                echo ErrorController::getError($request);
            }
        }
    }

?>