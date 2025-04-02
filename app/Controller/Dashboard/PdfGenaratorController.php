<?php
    namespace App\Controller\Dashboard;
    use App\Utils\ViewManager;
    use App\Controller\Dashboard\ErrorController;
    use App\Controller\GlobalPageController;
    use App\Model\Entity\ArrecadacaoEntity;
use App\Model\Entity\ArrecadacaoRegisterEntity;
use App\Utils\Funcoes;
    use App\Utils\ViewManagerPdf;
    use DateTime;
    use Dompdf\Dompdf;
    use Dompdf\Options;

    class PdfGenaratorController extends GlobalPageController{
        private static function changeDateType($data){
            // Divida a string nas duas datas
            $dates = explode(' - ', $data);

            // Converta a primeira data
            $start_date = DateTime::createFromFormat('F j, Y', $dates[0])->format('Y-m-d');

            // Converta a segunda data
            $end_date = DateTime::createFromFormat('F j, Y', $dates[1])->format('Y-m-d');

            return "'" . $start_date . "' AND '" . $end_date . "'";
        }

        #========================================================
        # Busca na base de dados
        #========================================================
        /*private static function getWithdrawItemReturn($where){
            $itens = '';
            $results = ArrecadacaoEntity::getArrecadacao($where, 'codigo_arrecadacao ASC', null);
            $contador = 1;
            while ($objArrecacao = $results->fetchObject(ArrecadacaoEntity::class)){ 
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('pdfreports/withdrawItem', [
                    'contador'              => $contador,
                    'codigo'                => $objArrecacao->codigo_arrecadacao,
                    'nome_completo'         => $objArrecacao->nome_funcionario,
                    'imagem'                => $objArrecacao->fotografia,
                    'tipo_armamento'        => $objArrecacao->tipo_armamento,
                    'numero'                => $objArrecacao->numero_de_serie_arma,
                    'municoes'              => $objArrecacao->quantidade_municao,
                    'patente'               => $objArrecacao->patente_funcionario,
                    'assinatura'            => $objArrecacao->assinatura_arrecadacao,
                    'telefone'              => $objArrecacao->celular_funcionario,
                    'data_retirada'         => $objArrecacao->data_levantamento,
                ]);
                $contador++;
            }

            return $itens; 
        }*/

        private static function getWithdrawItemReturn($where){
            $itens = '';
            $results = ArrecadacaoRegisterEntity::getArrecadacao($where, 'codigo_arrecadacao ASC', null);
            $contador = 1;
            while ($objArrecacao = $results->fetchObject(ArrecadacaoRegisterEntity::class)){ 
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('pdfreports/withdrawItem', [
                    'contador'              => $contador,
                    'codigo'                => $objArrecacao->codigo_arrecadacao,
                    'nome_completo'         => $objArrecacao->nome_funcionario,
                    'imagem'                => $objArrecacao->fotografia,
                    'tipo_armamento'        => $objArrecacao->tipo_armamento,
                    'numero'                => $objArrecacao->numero_de_serie_arma,
                    'municoes'              => $objArrecacao->quantidade_municao,
                    'patente'               => $objArrecacao->patente_funcionario,
                    'assinatura'            => $objArrecacao->assinatura_arrecadacao,
                    'telefone'              => $objArrecacao->celular_funcionario,
                    'data_retirada'         => $objArrecacao->data_levantamento,
                ]);
                $contador++;
            }

            return $itens; 
        }


        private static function getReturnItemReturn($where){
            $itens = '';
            $results = ArrecadacaoRegisterEntity::getArrecadacao($where, 'codigo_arrecadacao ASC', null);
            $contador = 1;
            while ($objArrecacao = $results->fetchObject(ArrecadacaoRegisterEntity::class)){ 
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('pdfreports/returnItem', [
                    'contador'              => $contador,
                    'codigo'                => $objArrecacao->codigo_arrecadacao,
                    'nome_completo'         => $objArrecacao->nome_funcionario,
                    'tipo_armamento'        => $objArrecacao->tipo_armamento,
                    'numero'                => $objArrecacao->numero_de_serie_arma,
                    'municoes'              => $objArrecacao->quantidade_municao,
                    'patente'               => $objArrecacao->patente_funcionario,
                    'data_retirada'         => $objArrecacao->data_levantamento,
                    'data_devolucao'        => $objArrecacao->data_devolucao,
                    'assinaturaFiel'        => $objArrecacao->assinatura_devolucao,
                    'assinaturaReceptor'    => $objArrecacao->assinatura_fiel
                ]);
                $contador++;
            }

            return $itens; 
        }

        #============================================================================
        # Funcoes relacionadas a geracao do PDF
        #============================================================================
        public static function withdrawPDFGenarator($request) {
            try {
        
                #=============================================================
                # Verificações das datas
                #=============================================================
                $postVars = $request->getPostVars();
        
                $specificDate   = $postVars['selectedDateRange'];
                $allDates       = $postVars['text_data_checkbox'] ?? '';

                $tableItems = '';
        
                if($specificDate != '' && $allDates == '' || $specificDate != '' && $allDates != ''){
                    $data_buscar = self::changeDateType($specificDate);
        
                    // Pegando os itens para a tabela dinamicamente
                    $tableItems = self::getWithdrawItemReturn("data_levantamento BETWEEN ".$data_buscar." AND data_devolucao is NULL");

                    // Remover as aspas
                    $date_range = str_replace("'", "", $data_buscar);
                    
                    // Separar as datas
                    $dates = explode(" AND ", $date_range);
                    
                    // Criar objetos DateTime e formatar as datas para o formato dd-mm-yyyy
                    $start_date = DateTime::createFromFormat('Y-m-d', $dates[0])->format('d-m-Y');
                    $end_date = DateTime::createFromFormat('Y-m-d', $dates[1])->format('d-m-Y');
                    
                    // Concatenar as datas novamente
                    $formatted_date_range = $start_date . ' ate ' . $end_date;
                    $titulo = 'Relatório Parcial de Leventamentos do Arsenal referente a '.$formatted_date_range;
        
                }
                
                if($allDates != '' && $specificDate == ''){
                    // Pegando os itens para a tabela dinamicamente
                    $tableItems = self::getWithdrawItemReturn("data_devolucao is NULL");
                    $titulo = 'Relatório Geral de Leventamentos do Arsenal';
                } 

                //Caso nao se especifique algum periodo para imprimir
                if($specificDate == '' && $allDates == '')  $request->getRouter()->redirect('/report-withdraw?status=dataerror');
        
                #=============================================================
                # Verificações das datas
                #=============================================================
        
                // Inicializa o Dompdf
                $dompdf = new Dompdf();
                $options = new Options();
                $options->setIsRemoteEnabled(true); // Habilitar carregamento remoto de recursos
            
                // Configuração do caminho correto
                $chrootPath = realpath(__DIR__);
                if ($chrootPath === false) {
                    throw new \Exception("Erro: o diretório de chroot não pôde ser encontrado.");
                }
            
                $options->setChroot($chrootPath);
                $dompdf->setOptions($options);
            
                // Corrigindo o caminho para o arquivo HTML
                $htmlPath = realpath($chrootPath . '/../../../resources/views/pdfreports/withdraw.html');
                if ($htmlPath === false) {
                    throw new \Exception("Erro: o arquivo withdraw.html não pôde ser encontrado.");
                }
            
                // Carregar o conteúdo do arquivo HTML
                $html = file_get_contents($htmlPath);
                // Titulo
                $html = str_replace('{{titulo}}', $titulo, $html);
        
                // Data atual (dia, mês e ano)
                $dataAtual = parent::getNowDateTime();
                $html = str_replace('{{data_atual}}', $dataAtual, $html);

                $utilizador = $_SESSION['admin']['utilizador']['nome_utilizador'];
                $html = str_replace('{{utilizador}}', $utilizador, $html);
        
                #============================================================
                # Carregando informações e mandando para tabela
                #============================================================
                // Aqui vamos substituir {{tableItem}} com o conteúdo gerado pela função
                $html = str_replace('{{tableItem}}', $tableItems, $html);
            
                // Carregar HTML com o Dompdf
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape'); // Configurar o formato da página
                $dompdf->render();
            
                // Enviar cabeçalhos para exibir o PDF
                $output = $dompdf->output();
                header('Content-Type: application/pdf');
                echo $output;
            
            } catch (\Exception $e) {
                echo "Erro ao gerar o PDF: " . $e->getMessage();
            }
        }


        public static function ReturnPDFGenarator($request) {
            try {
        
                #=============================================================
                # Verificações das datas
                #=============================================================
                $postVars = $request->getPostVars();
        
                $specificDate   = $postVars['selectedDateRange'];
                $allDates       = $postVars['text_data_checkbox'] ?? '';

                $tableItems = '';
        
                if($specificDate != '' && $allDates == '' || $specificDate != '' && $allDates != ''){
                    $data_buscar = self::changeDateType($specificDate);
        
                    // Pegando os itens para a tabela dinamicamente
                    $tableItems = self::getReturnItemReturn("data_levantamento BETWEEN ".$data_buscar." AND data_devolucao is not NULL");

                    // Remover as aspas
                    $date_range = str_replace("'", "", $data_buscar);
                    
                    // Separar as datas
                    $dates = explode(" AND ", $date_range);
                    
                    // Criar objetos DateTime e formatar as datas para o formato dd-mm-yyyy
                    $start_date = DateTime::createFromFormat('Y-m-d', $dates[0])->format('d-m-Y');
                    $end_date = DateTime::createFromFormat('Y-m-d', $dates[1])->format('d-m-Y');
                    
                    // Concatenar as datas novamente
                    $formatted_date_range = $start_date . ' ate ' . $end_date;
                    $titulo = 'Relatório Parcial de Leventamentos do Arsenal referente a '.$formatted_date_range;
        
                }
                
                if($allDates != '' && $specificDate == ''){
                    // Pegando os itens para a tabela dinamicamente
                    $tableItems = self::getReturnItemReturn("data_devolucao is not NULL");
                    $titulo = 'Relatório Geral de Leventamentos do Arsenal';
                } 

                //Caso nao se especifique algum periodo para imprimir
                if($specificDate == '' && $allDates == '')  $request->getRouter()->redirect('/report-return?status=dataerror');
        
                #=============================================================
                # Verificações das datas
                #=============================================================
        
                // Inicializa o Dompdf
                $dompdf = new Dompdf();
                $options = new Options();
                $options->setIsRemoteEnabled(true); // Habilitar carregamento remoto de recursos
            
                // Configuração do caminho correto
                $chrootPath = realpath(__DIR__);
                if ($chrootPath === false) {
                    throw new \Exception("Erro: o diretório de chroot não pôde ser encontrado.");
                }
            
                $options->setChroot($chrootPath);
                $dompdf->setOptions($options);
            
                // Corrigindo o caminho para o arquivo HTML
                $htmlPath = realpath($chrootPath . '/../../../resources/views/pdfreports/return.html');
                if ($htmlPath === false) {
                    throw new \Exception("Erro: o arquivo withdraw.html não pôde ser encontrado.");
                }
            
                // Carregar o conteúdo do arquivo HTML
                $html = file_get_contents($htmlPath);
                // Titulo
                $html = str_replace('{{titulo}}', $titulo, $html);
        
                // Data atual (dia, mês e ano)
                $dataAtual = parent::getNowDateTime();
                $html = str_replace('{{data_atual}}', $dataAtual, $html);

                $utilizador = $_SESSION['admin']['utilizador']['nome_utilizador'];
                $html = str_replace('{{utilizador}}', $utilizador, $html);
        
                #============================================================
                # Carregando informações e mandando para tabela
                #============================================================
                // Aqui vamos substituir {{tableItem}} com o conteúdo gerado pela função
                $html = str_replace('{{tableItem}}', $tableItems, $html);
            
                // Carregar HTML com o Dompdf
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape'); // Configurar o formato da página
                $dompdf->render();
            
                // Enviar cabeçalhos para exibir o PDF
                $output = $dompdf->output();
                header('Content-Type: application/pdf');
                echo $output;
            
            } catch (\Exception $e) {
                echo "Erro ao gerar o PDF: " . $e->getMessage();
            }
        }


        
        
        
        
        #============================================================================
        # FIM Funcoes relacionadas a geracao do PDF
        #============================================================================
    }

?>