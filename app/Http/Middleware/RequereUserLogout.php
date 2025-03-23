<?php
    namespace App\Http\Middleware;
    use \App\Session\Login\LoginSession as  SessionAdminLogin;

    class RequereUserLogout{
        public function handle($request, $next){
            if(SessionAdminLogin::isLoged()){
                $request->getRouter()->redirect('/painel');
            }
            return $next($request);
         }
    }
?>