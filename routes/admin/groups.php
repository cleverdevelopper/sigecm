<?php
    use App\Http\Response;
    use App\Controller\Dashboard\GroupManagementController;

    $objRouter->get('/groupmanagement', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, GroupManagementController::getGrupos($request));
        }
    ]);

   $objRouter->get('/newgroup', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, GroupManagementController::getNewGrupo($request));
        }
    ]);

    $objRouter->post('/newgroup', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, GroupManagementController::setNewGrupo($request));
        }
    ]);

    /* $objRouter->get('/grupos/{id}/edit', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request, $id){
            return new Response(200, GrupoController::getEditGrupo($request, $id));
        }
    ]);

    $objRouter->post('/grupos/{id}/edit', [
         'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request, $id){
            return new Response(200, GrupoController::setEditGrupo($request, $id));
        }
    ]);*/
?>