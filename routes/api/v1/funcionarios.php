<?php
    use App\Http\Response;
    use App\Controller\Api;

    $objRouter->get('/api/funcionarios', [
        'middlewares' => [
            'api'
        ],
        function ($request){
            return new Response(200, Api\FuncionariosApiController::getFuncionarios($request), 'application/json');
        }
    ]);
?>