<?php
    use App\Controller\Login;;
    use App\Http\Response;

   
    $objRouter->get('/', [
        'middlewares'   => [
            'requere-admin-logout'
        ],
        function ($request){
            return new Response(200, Login\LoginController::getLoginPage($request));
        }
    ]);

    $objRouter->get('/logout', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, Login\LoginController::setLogout($request));
        }
    ]);

    $objRouter->post('/', [
        'middlewares'   => [
            'requere-admin-logout'
        ],
        function ($request){
            return new Response(200, Login\LoginController::setLoginPage($request));
        }
    ]);


    $objRouter->get('/recuperar', [
        function (){
            return new Response(200, Login\RecuperarController::getRecuperarPage());
        }
    ]);

    $objRouter->get('/pagina/{idPagina}/{accao}', [
        function($idPagina, $accao){
            return new Response(200, 'Pagina '.$idPagina.' - '.$accao);
        }
    ]);

?>