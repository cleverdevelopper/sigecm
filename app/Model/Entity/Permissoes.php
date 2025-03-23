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
            'permissao'         => 'Gestao de utilizadores',
            'funcionalidade'    => 'Visualizar e gerir utilizadores'
        ],
        [
            'permissao'         => 'Gestao de Funcionarios',
            'funcionalidade'    => 'Visualizar e cadastrar funcionarios'
        ],
        [
            'permissao'         => 'Gestao de Departamentos',
            'funcionalidade'    => 'Visualizar e cadastrar especialidades'
        ],
        [
            'permissao'         => 'Gestao de Configuracoes',
            'funcionalidade'    => 'Gestao de configuracoes do sistema'
        ],

        //==========================================
        // Permissoes de Gestao de Visitas
        //==========================================
        [
            'permissao'         => 'Supervisor do Grupo',
            'funcionalidade'    => 'Gestor do grupo de Visitantes'
        ], 
        [
            'permissao'         => 'Gestao de Entradas',
            'funcionalidade'    => 'Visualiza e cadastra Visitantes'
        ], 
        [
            'permissao'         => 'Gestao de Saidas',
            'funcionalidade'    => 'Visualiza e cadastra Saidas de Visitantes'
        ],
        [
            'permissao'         => 'Geracao de Relatorios',
            'funcionalidade'    => 'Imprimir relatorios das Entradas e Saidas'
        ],

        //==========================================
        // Permissoes do Armamento
        //==========================================
        [
            'permissao'         => 'Gestao de Medicamentos',
            'funcionalidade'    => 'Visualizar e cadastrar Medicamentos'
        ], 
        [
            'permissao'         => 'Entrada de Medicamentos',
            'funcionalidade'    => 'Gestao de entrada de medicamentos'
        ],
        [
            'permissao'         => 'Agendamentos',
            'funcionalidade'    => 'Gestao e realizacao de Agendamentos'
        ],


    ]

?>