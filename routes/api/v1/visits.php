<?php
    use App\Http\Response;
    use App\Controller\Api;

    $objRouter->get('/api/users/{image}', [
        'middlewares' => [
            'api'
        ],
        function ($request, $image){
            return new Response(200, Api\GuestApiController::getGuestByImage($request,  $image), 'application/json');
        }
    ]);
?>