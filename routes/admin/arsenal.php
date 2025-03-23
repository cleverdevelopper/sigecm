<?php
    use App\Http\Response;
    use App\Controller\Dashboard\ArsenalManagementController;
use App\Controller\Dashboard\PdfGenaratorController;

    #======================================================
    # Rotas referentes a classificacao
    #======================================================
    $objRouter->get('/weapontype', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getWeaponTypesPage($request));
        }
    ]);

    $objRouter->get('/newweapontype', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getNewWeaponType($request));
        }
    ]); 

    $objRouter->post('/newweapontype', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::setNewWeaponType($request));
        }
    ]); 
    
    #======================================================
    # Fim Rotas referentes a classificacao
    #======================================================

    #======================================================
    # Rotas referentes ao armamento
    #======================================================
    $objRouter->get('/weapons', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getWeaponsPage($request));
        }
    ]);

    $objRouter->get('/newweapon', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getNewWeapon($request));
        }
    ]); 

    $objRouter->post('/newweapon', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::setNewWeapon($request));
        }
    ]); 
    
    #======================================================
    # Fim Rotas referentes ao armamento
    #======================================================


    #======================================================
    # Rotas referentes as Municoes
    #======================================================
    $objRouter->get('/ammunition', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getAmmunitionPage($request));
        }
    ]);

    $objRouter->get('/newammunition', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getNewAmmunition($request));
        }
    ]); 

    $objRouter->post('/newammunition', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::setNewAmmunition($request));
        }
    ]); 
    #======================================================
    # Fim Rotas referentes as Municoes
    #======================================================

    #======================================================
    # Rotas referentes as Equipamentos
    #======================================================
    $objRouter->get('/equipment', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getEquipmentPage($request));
        }
    ]);

    $objRouter->get('/newequipment', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getNewEquipment($request));
        }
    ]); 

    $objRouter->post('/newequipment', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::SetNewEquipment($request));
        }
    ]);

    $objRouter->get('/equipment-withdraw', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getNewEquipmentWithdraw($request));
        }
    ]);
    
    $objRouter->post('/equipment-withdraw', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::SetNewEquipmentWithdraw($request));
        }
    ]);

    #======================================================
    # Fim Rotas referentes as Equipamentos
    #======================================================


    #======================================================
    # Rotas referentes a ARECADACAO
    #======================================================

    #==========================================
    # RETIRADA DO ARMAMENTO
    #==========================================
    $objRouter->get('/withdraw', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getWeaponsInventoryPage($request));
        }
    ]);

    # geracao do pdf
    $objRouter->post('/withdraw', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, PdfGenaratorController::withdrawPDFGenarator($request));
        }
    ]);

    $objRouter->get('/new-withdraw', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getNewWithdraw($request));
        }
    ]); 

    $objRouter->post('/new-withdraw', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::SetNewWithdraw($request));
        }
    ]);
    #==========================================
    # FIM RETIRADA DO ARMAMENTO
    #==========================================

    #==========================================
    # DEVOLUCAO DO ARMAMENTO
    #==========================================
    $objRouter->get('/return-weapon', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ArsenalManagementController::getWeaponsReturnPage($request));
        }
    ]);

    $objRouter->get('/new-return-weapon&id={id}', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request, $id){
            return new Response(200, ArsenalManagementController::getNewWeaponReturn($request, $id));
        }
    ]);

    $objRouter->post('/new-return-weapon&id={id}', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request, $id){
            return new Response(200, ArsenalManagementController::SetNewReturn($request, $id));
        }
    ]);
    #==========================================
    # FIM DEVOLUCAO DO ARMAMENTO
    #==========================================
    #======================================================
    # Fim Rotas referentes a  ARECADACAO
    #======================================================
?>