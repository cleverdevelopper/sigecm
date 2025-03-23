<?php
    use App\Http\Response;
    use App\Controller\Dashboard\EnterManagementController;

    $objRouter->get('/visitregister', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, EnterManagementController::getEnterPage($request));
        }
    ]);

   $objRouter->post('/visitregister', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, EnterManagementController::setGuest($request));
        }
    ]);


    $objRouter->get('/visitors', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, EnterManagementController::getVisitorsPage($request));
        }
    ]);

    $objRouter->get('/exitregister', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, EnterManagementController::getExitsPage($request));
        }
    ]);

    $objRouter->post('/exitregister', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, EnterManagementController::setExitGuest($request));
        }
    ]);

    $objRouter->get('/visitorsreports', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, EnterManagementController::getReportsPage($request));
        }
    ]);


?>