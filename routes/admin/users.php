<?php
    use App\Http\Response;
    use App\Controller\Dashboard\UsersManagementController;

    $objRouter->get('/usersmanagement', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, UsersManagementController::getUtilizadores($request));
        }
    ]);

?>