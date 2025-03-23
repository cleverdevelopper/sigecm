<?php
    require __DIR__.'/includes/app.php';
    use App\Http\Router;

    $objRouter = new Router(URL);
        include __DIR__.'/routes/routes.php';

    $objRouter->run()
              ->sendResponse();
?>