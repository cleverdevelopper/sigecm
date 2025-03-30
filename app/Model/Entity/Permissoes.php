<?php
    //=============================================
    // Ficheiro das permissoes do sistema
    //=============================================

    return[
        //==========================================
        // Administracao do sistema
        //==========================================
        [
            'permissao'         => 'Grupo de utilizadores',
            'funcionalidade'    => 'Visualizar e cadastrar grupo de utilizadores'
        ], 
        [
            'permissao'         => 'Gestão de utilizadores',
            'funcionalidade'    => 'Visualizar e gerir utilizadores'
        ],
        [
            'permissao'         => 'Gestão de Funcionários',
            'funcionalidade'    => 'Visualizar e cadastrar funcionários'
        ],
        [
            'permissao'         => 'Gestão de Departamentos',
            'funcionalidade'    => 'Visualizar e cadastrar Departamentos'
        ],
        [
            'permissao'         => 'Gestão de Configurações',
            'funcionalidade'    => 'Gestão de configurações do sistema'
        ],

        //==========================================
        // Permissoes de Gestao de Visitas
        //==========================================
        [
            'permissao'         => 'Supervisor do Grupo',
            'funcionalidade'    => 'Gestor do grupo de Visitantes'
        ], 
        [
            'permissao'         => 'Gestão de Entradas',
            'funcionalidade'    => 'Visualiza e cadastra Visitantes'
        ], 
        [
            'permissao'         => 'Gestão de Saidas',
            'funcionalidade'    => 'Visualiza e cadastra Saidas de Visitantes'
        ],
        [
            'permissao'         => 'Geração  de Relatórios ',
            'funcionalidade'    => 'Imprimir relatórios das Entradas e Saidas'
        ],

        //==========================================
        // Permissoes do Armamento
        //==========================================
        [
            'permissao'         => 'Supervisor do Grupo',
            'funcionalidade'    => 'Gestor do grupo de Armamento'
        ], 
        [
            'permissao'         => 'Arrecadação  ',
            'funcionalidade'    => 'Permissão de retirada e devolução  do Armamento'
        ], 
        [
            'permissao'         => 'Armamento',
            'funcionalidade'    => 'Permissão de Cadastrar Armarmamento e seu tipo'
        ],
        [
            'permissao'         => 'Munições',
            'funcionalidade'    => 'Permissão de Cadastrar Munições e seu tipo'
        ],
        [
            'permissao'         => 'Equipamentos',
            'funcionalidade'    => 'Permissão de Cadastrar Equipamentos e seu tipo'
        ],
        [
            'permissao'         => 'Consultas',
            'funcionalidade'    => 'Permissão de Realizar consultas e gerar relatórios '
        ],
        [
            'permissao'         => 'Gestão  de Estoque',
            'funcionalidade'    => 'Acesso ao inventario e aumentar o Estoque'
        ],


    ]

?>