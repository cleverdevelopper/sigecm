<?php
    namespace App\Http\Middleware;

    use App\Controller\GlobalPageController;
    use App\Utils\ViewManager;

    class Maintenance extends GlobalPageController{
        //Metodo responsavel por executar as accoes do Middleware
        public function handle($request, $next){
            //Verifica o estado de manutencao de uma pagina
            $content = ViewManager::render('dashboard/modules/maintenance/maintenance', []);

            if(getenv('MAINTENANCE') == 'true'){
                throw new \Exception(parent::getPage('SIGECM | Manutencao', $content), 200);
            }
            //Executa o proximo nivel de Middleware
           return $next($request);
        }
    }
?>
