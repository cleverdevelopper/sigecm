<?php
    namespace App\Controller\Dashboard;
    use App\Controller\GlobalPageController;
    use App\Utils\ViewManager;

    class ErrorController extends GlobalPageController{
        public static function getError($request){
            $content = ViewManager::render('dashboard/modules/error404/error', [
                
            ]);
            return parent::getPage('SIGECM | Error', $content);
        }
    }
?>