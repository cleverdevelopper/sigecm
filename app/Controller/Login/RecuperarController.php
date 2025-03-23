<?php
    namespace App\Controller\Login;
    use App\Utils\ViewManager;

    class RecuperarController extends PageController{
        public static function getRecuperarPage(){
            $content =  ViewManager::render('login/recuperar', [
            ]);

            return parent::getPage('Centro medico - Recuperar', $content);
        }
    }
?>