<?php
    namespace App\Controller\Dashboard;
    use App\Controller\GlobalPageController;
    use App\Utils\ViewManager;

    class EpiController extends GlobalPageController{
        public static function getEpi($request){
            $content = ViewManager::render('dashboard/modules/arsenalmanagement/epi/epi', [
                'navbar'            => parent::getNavbar(),
                'sidebar'           => parent::getMenu(),
                'rightsidebar'      => parent::getRightSidebar(),
                'footer'            => parent::getFooter(),
            ]);
            return parent::getPage('SIGECM | EPI', $content);
        }
    }
?>