<?php
    use App\Http\Response;
    use App\Controller\Api;

    $objRouter->get('/api/armamento', [
        'middlewares' => [
            'api'
        ],
        function ($request){
            return new Response(200, Api\ArmamentoApiController::getArmamentos($request), 'application/json');
        }
    ]);
?>