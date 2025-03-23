<?php
    use App\Http\Response;
    use App\Controller\Dashboard\PasswordConfigController;

    $objRouter->get('/settings', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, PasswordConfigController::getPasswordResetPage($request));
        }
    ]);

    $objRouter->post('/settings', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, PasswordConfigController::setPasswordResetPage($request));
        }
    ]);  
?>