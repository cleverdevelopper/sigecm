<?php
    use App\Http\Response;
    use App\Controller\Dashboard\EpiController;

    $objRouter->get('/epibook', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, EpiController::getEpi($request));
        }
    ]);

?>