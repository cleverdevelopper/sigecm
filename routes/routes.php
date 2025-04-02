<?php

    #===================================================
    #  Rotas relacionadas com dashboard
    #===================================================
    include __DIR__.'/admin/dashboard.php';
    include __DIR__.'/admin/settings.php';
    include __DIR__.'/admin/users.php';
    include __DIR__.'/admin/groups.php';
    include __DIR__.'/admin/enter.php';
    include __DIR__.'/admin/arsenal.php';
    include __DIR__.'/admin/epi.php';

    #===================================================
    #  Rotas relacionadas com API
    #===================================================
    include __DIR__.'/api/v1/visits.php';
    include __DIR__.'/api/v1/funcionarios.php';
    include __DIR__.'/api/v1/armamento.php';

    #===================================================
    #  Rotas relacionadas com dashboard
    #===================================================
    include __DIR__.'/login/login.php';
?>