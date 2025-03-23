<?php
    namespace App\Http\Middleware;
    use \App\Session\Login\LoginSession as  SessionAdminLogin;

    class RequereUserLogin{
         public function handle($request, $next){
            if(!SessionAdminLogin::isLoged()){
                $request->getRouter()->redirect('/');
            }
             return $next($request);
         }
    }
?>