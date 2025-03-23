<?php
    namespace App\Controller\Dashboard;
    use App\Utils\ViewManager;
    use App\Controller\Dashboard\ErrorController;
    use App\Controller\GlobalPageController;
    use App\Model\Entity\AmmunitionEntity;
    use App\Model\Entity\ArrecadacaoEntity;
    use App\Model\Entity\EquipamentosQuantEntity;
    use App\Model\Entity\EquipmentEntity;
    use App\Model\Entity\StatusArmamentoEntity;
    use App\Model\Entity\WeaponEntity;
    use App\Model\Entity\WeaponTypeEntity;
    use App\Utils\Funcoes;
    use DateTime;
    use Dompdf\Dompdf;
use Dompdf\Options;

    class ArsenalManagementController extends GlobalPageController{
        #==========================================================================
        # funcoes que lidam com as formatacoes das datas
        #==========================================================================
        private static function date_format($data_original) {
            $date = DateTime::createFromFormat('m/d/Y', $data_original);
        
            if ($date) {
                return $date->format('Y-m-d');
            } else {
                return false; 
            }
        }
        #==========================================================================
        # Fim das funcoes que lidam com as formatacoes das datas
        #==========================================================================

        #============================================================================
        # Funcoes relacionadas as classificacoes das armas
        #============================================================================
        public static function getNewWeaponType($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapon_types/newWeaponType',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                ]);

                return parent::getPage('SIGECM | Nova Tipo de Armamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }

        public static function setNewWeaponType($request){
            $postVars = $request->getPostVars();

            $objWeaponType = new WeaponTypeEntity;
            $objWeaponType->classificacao                   = $postVars['text_classificacao'];
            $objWeaponType->tipo_armamento                  = $postVars['text_tipo_armamento'];
            $objWeaponType->tipo_uso                        = $postVars['text_tipo_uso'];
            $objWeaponType->potencia                        = $postVars['text_potencia'];
            $objWeaponType->alcance_eficaz                  = $postVars['text_alcance_eficaz'];
            $objWeaponType->tipo_municao                    = $postVars['text_tipo_municao'];
            $objWeaponType->calibre_municao                 = $postVars['text_calibre_municao'];
            $objWeaponType->pais_origem                     = $postVars['text_pais_origem'];
            $objWeaponType->finalidade                      = $postVars['text_finalidade'];
            $objWeaponType->categoria_perigo                = $postVars['text_categoria_perigo'];
            $objWeaponType->descricao                       = $postVars['text_descricao'];
            $objWeaponType->criado_em                       = parent::getNowDateTime();
            $objWeaponType->atualizado_em                   = parent::getNowDateTime();

            $objWeaponType->cadastrar();

            $request->getRouter()->redirect('/weapontype?status=created');
        }


        private static function getWeaponTypeItens($request){
            $itens = '';
            $results = WeaponTypeEntity::getWeaponTypes(null, 'codigo_tipo_armamento DESC', null);
            While ($objWeaponType = $results->fetchObject(WeaponTypeEntity::class)){
                // Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapon_types/weaponTypeItem', [
                    'codigo'                => $objWeaponType->codigo_tipo_armamento,
                    'categoria'             => $objWeaponType->classificacao,
                    'subcategoria'          => $objWeaponType->tipo_armamento,
                    'finalidade'            => $objWeaponType->finalidade,
                    'calibre'               => $objWeaponType->calibre_municao,
                    'pais_origem'           => $objWeaponType->pais_origem,
                ]);
            }
            return $itens;
        }


        public static function getWeaponTypesPage($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapon_types/weaponTypes',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'itens'         => self::getWeaponTypeItens($request),
                ]);

                return parent::getPage('SIGECM | Armamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }
        #============================================================================
        # Fim Funcoes relacionadas as classificacoes das armas
        #============================================================================


        #============================================================================
        # Funcoes relacionadas ao Armamento
        #============================================================================
        private static function getStatusWeapon($request){
            $itens = '';
            $results = StatusArmamentoEntity::getStatus(null, 'codigo_status', null);
            while ($objStatus = $results->fetchObject(StatusArmamentoEntity::class)){
                // Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapons/statusItem', [
                    'codigo'        => $objStatus->codigo_status,
                    'status'        => $objStatus->status,
                ]);
            }
            return $itens;
        }

        private static function getWeaponTypeForNewWeapon($request){
            $itens = '';
            $results = WeaponTypeEntity::getWeaponTypes(null, 'codigo_tipo_armamento', null);
            while ($objType = $results->fetchObject(WeaponTypeEntity::class)){
                // Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapons/typeItem', [
                    'codigo_type' => $objType->codigo_tipo_armamento,
                    'type'        => $objType->tipo_armamento,
                ]);
            }
            return $itens;
        }

        public static function getNewWeapon($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapons/newWeapon',[
                    'navbar'                => parent::getNavbar(),
                    'sidebar'               => parent::getMenu(),
                    'rightsidebar'          => parent::getRightSidebar(),
                    'footer'                => parent::getFooter(),
                    'typeItem'              => self::getWeaponTypeForNewWeapon($request),
                    'status'                => self::getStatusWeapon($request)
                ]);
                return parent::getPage('SIGECM | Nova Arma', $content);
            }else{
                return ErrorController::getError($request);
            }
        }

        public static function setNewWeapon($request){
            $postVars = $request->getPostVars();

            $weapon_type_id = (int) $postVars['tipo_armamento'];
            $objWeaponType = WeaponTypeEntity::getWeaponTypeById($weapon_type_id);

            $objArsenal = new WeaponEntity;
            $objArsenal->codigo_tipo_armamento           = $postVars['tipo_armamento'];
            $objArsenal->nome_armamento                  = $objWeaponType->tipo_armamento;
            $objArsenal->numero_serie                    = $postVars['text_numero_serie'];
            $objArsenal->marca                           = $postVars['text_marca'];
            $objArsenal->modelo                          = $postVars['text_modelo'];
            $objArsenal->calibre                         = $objWeaponType->calibre_municao;
            $objArsenal->peso                            = $postVars['text_peso_arma'];
            $objArsenal->local_armazenamento             = $postVars['text_local_armazenamento'];
            $objArsenal->status_operacional              = $postVars['text_status'];
            $objArsenal->disponibilidade                 = 1;
            $objArsenal->data_aquisicao                  = self::date_format($postVars['text_data_aquisicao']);
            $objArsenal->data_ultima_inspecao            = self::date_format($postVars['text_data_inspencao']);
            $objArsenal->data_ultimo_uso                 = self::date_format($postVars['text_data_uso']);
            $objArsenal->observacoes                     = $postVars['text_obs'];
            $objArsenal->cadastrado_por                  = $_SESSION['admin']['utilizador']['nome_utilizador'];;
            $objArsenal->criado_em                       = parent::getNowDateTime();
            $objArsenal->atualizado_em                   = parent::getNowDateTime();

            $objArsenal->cadastrar();
            $request->getRouter()->redirect('/weapons?status=created');
        }



        private static function getWeaponsItens($request) {
            $itens = '';
            $results = WeaponEntity::getWeapons(null, 'codigo_armamento DESC', null);
            
            // Iterate through each type
            while ($objArmamento = $results->fetchObject(WeaponEntity::class)) {
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapons/weaponItem', [
                    'codigo'                => $objArmamento->codigo_tipo_armamento,
                    'serie'                 => $objArmamento->numero_serie,
                    'tipo'                  => $objArmamento->nome_armamento,
                    'status'                => $objArmamento->status_operacional,
                    'calibre'               => $objArmamento->calibre,
                    'inspensao'             => $objArmamento->data_ultima_inspecao
                ]);
            }
            
            return $itens;
        }


        public static function getWeaponsPage($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapons/weapons',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'itens'         => self::getWeaponsItens($request),
                ]);

                return parent::getPage('SIGECM | Armamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }
        #============================================================================
        # Fim Funcoes relacionadas ao Armamento
        #============================================================================

        #============================================================================
        # Funcoes relacionadas as Municoes
        #============================================================================
        private static function getWeaponsItensForAmmunition($request) {
            $itens = '';
            $results = WeaponEntity::getWeapons(null, 'codigo_armamento', null);
            // Iterate through each type
            while ($objWeapon = $results->fetchObject(WeaponEntity::class)) {
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/ammunition/weaponTypeItem', [
                    'codigo'                      => $objWeapon->codigo_tipo_armamento,
                    'WeaponType'                  => $objWeapon->nome_armamento
                ]);
            }
            
            return $itens;
        }
        public static function getNewAmmunition($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/ammunition/newAmmunition',[
                    'navbar'                => parent::getNavbar(),
                    'sidebar'               => parent::getMenu(),
                    'rightsidebar'          => parent::getRightSidebar(),
                    'footer'                => parent::getFooter(),
                    'typeItem'              => self::getWeaponsItensForAmmunition($request),
                ]);
                return parent::getPage('SIGECM | Nova Municao', $content);
            }else{
                return ErrorController::getError($request);
            }
        }


        public static function setNewAmmunition($request){
            if(Funcoes::Permition(1)){
                $postVars = $request->getPostVars();

                $cod_type = (int) $postVars['text_type'];
                $quantinty = (int) $postVars['text_quantidade'];

                $objAmmunition = new AmmunitionEntity;
                $objAmmunition->nome                   = $postVars['text_calibre_municao'];
                $objAmmunition->calibre                = $postVars['text_calibre_municao'];
                $objAmmunition->tipo                   = $postVars['text_tipo_municao'];
                $objAmmunition->peso                   = $postVars['text_peso_municao'];
                $objAmmunition->velocidade_inicial     = $postVars['text_velocidade_inicial'];
                $objAmmunition->capacidade_penetracao  = $postVars['text_capacidade_penetracao'];
                $objAmmunition->fabricante             = $postVars['text_fabriante'];
                $objAmmunition->data_fabricacao        = self::date_format($postVars['text_data_fabricacao']);
                $objAmmunition->quantidade_estoque     = $quantinty;
                $objAmmunition->arma_compativel        = $cod_type;
                $objAmmunition->observacoes            = $postVars['text_descricao'];
                $objAmmunition->criado_em              = parent::getNowDateTime();
                $objAmmunition->atualizado_em          = parent::getNowDateTime();

                $objAmmunition->cadastrar();

                $request->getRouter()->redirect('/ammunition?status=created');
            }else{
                return ErrorController::getError($request);
            }
        }

        private static function getAmmunitionItens($request){
            $itens = '';
            $results = AmmunitionEntity::getAmmunition(null, 'codigo_municao DESC', null);
            While ($objAmmunition = $results->fetchObject(AmmunitionEntity::class)){
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/ammunition/ammunitionItem', [
                    'codigo'                => $objAmmunition->codigo_municao,
                    'calibre'               => $objAmmunition->nome,
                    'tipo'                  => $objAmmunition->tipo,
                    'quantidade'            => $objAmmunition->quantidade_estoque,
                    'velocidade'            => $objAmmunition->velocidade_inicial,
                ]);
            }
            return $itens;
        }

        public static function getAmmunitionPage($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/ammunition/ammunition',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'itens'         => self::getAmmunitionItens($request),
                ]);

                return parent::getPage('SIGECM | Armamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }
        #============================================================================
        # Funcoes relacionadas as Municoes
        #============================================================================

        #============================================================================
        # Funcoes relacionadas aos equipamentos
        #============================================================================
        public static function getNewEquipment($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/equipment/newEquipment',[
                    'navbar'                => parent::getNavbar(),
                    'sidebar'               => parent::getMenu(),
                    'rightsidebar'          => parent::getRightSidebar(),
                    'footer'                => parent::getFooter(),
                ]);
                return parent::getPage('SIGECM | Nova Equipamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }

        public static function SetNewEquipment($request){
            if(Funcoes::Permition(1)){
                $postVars = $request->getPostVars();

                $quantinty = (int) $postVars['text_quantidade'];

                $objEquipment = new EquipmentEntity;
                $objEquipment->tipo                   = $postVars['text_tipo_equipamento'];
                $objEquipment->nome                   = $postVars['text_nome_equipamento'];
                $objEquipment->material               = $postVars['text_material_fabricacao'];
                $objEquipment->capacidade             = $postVars['capacidade_carga_protecao'];
                $objEquipment->peso                   = $postVars['text_peso'];
                $objEquipment->cor                    = $postVars['text_cor_equipamento'];
                $objEquipment->compatibilidade        = $postVars['text_compatibilidade'];
                $objEquipment->finalidade             = $postVars['text_finalidade'];
                $objEquipment->fabricante             = $postVars['text_fabricante'];
                $objEquipment->pais_origem            = $postVars['text_pais_origem'];
                $objEquipment->data_fabricacao        = self::date_format($postVars['text_data_fabricacao']);
                $objEquipment->estado                 = $postVars['text_estado_equipamento'];
                $objEquipment->quantidade             = $quantinty;
                $objEquipment->descricao              = $postVars['text_descricao'];
                $objEquipment->criado_em              = parent::getNowDateTime();
                $objEquipment->atualizado_em          = parent::getNowDateTime();

                $objEquipment->cadastrar();

                $request->getRouter()->redirect('/equipment?status=created');
            }else{
                return ErrorController::getError($request);
            }
        }

        private static function getEquipmentItens($request){
            $itens = '';
            $results = EquipmentEntity::getEquipments(null, 'codigo_equipamento DESC', null);
            While ($objEquipment = $results->fetchObject(EquipmentEntity::class)){
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/equipment/equipmentItem', [
                    'codigo'                => $objEquipment->codigo_equipamento,
                    'tipo'                  => $objEquipment->tipo,
                    'nome'                  => $objEquipment->nome,
                    'quantidade'            => $objEquipment->quantidade,
                    'cor'                   => $objEquipment->cor,
                    'finalidade'            => $objEquipment->finalidade,
                ]);
            }
            return $itens;
        }

        public static function getEquipmentPage($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/equipment/equipment',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'itens'         => self::getEquipmentItens($request),
                ]);

                return parent::getPage('SIGECM | Armamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }



        public static function SetNewEquipmentWithdraw($request){
            if(Funcoes::Permition(1)){
                $file = $request->getFile();
                $postVars = $request->getPostVars();

                $objQuantidades = new EquipamentosQuantEntity;

                #===========================================
                # Funcionario
                #===========================================
                $objQuantidades->codigo_funcionario             = $postVars['text_codigo'];
                $objQuantidades->nome_funcionario               = $postVars['text_full_name'];
                $objQuantidades->patente_funcionario            = $postVars['text_patente'];
                $objQuantidades->departamento                   = $postVars['text_departamento'];
                $objQuantidades->cargo                          = $postVars['text_cargo'];
                $objQuantidades->documento_identidade           = $postVars['text_documento'];
                $objQuantidades->celular_funcionario            = $postVars['text_celular'];
                $objQuantidades->celular_alt                    = $postVars['text_celular_alt'];
                $objQuantidades->fotografia                     = $postVars['text_fotografia'];


                #===========================================
                # Assinaturas
                #===========================================
                $objQuantidades->assinatura_levantamento        = $file;
                $objQuantidades->data_levantamento              = parent::getNowDate();;
                $objQuantidades->criado_em                      = parent::getNowDateTime();
                $objQuantidades->atualizado_em                  = parent::getNowDateTime();



                #=============================================
                # Logica para guardar os equipamentos
                #=============================================
                $equipamentos               = $postVars['text_equipamentos'];
                $quantidades_equipamentos   = json_decode($postVars['text_quantidades_equipamentos'], true);

                // Laço para iterar pelos arrays
                for ($i = 0; $i < count($equipamentos); $i++) { 
                    $codigo_equipamento = $equipamentos[$i]; 
                    $quantidade = $quantidades_equipamentos[$i]; 

                    $objEquipment = EquipmentEntity::getEquipmentById($codigo_equipamento);
                            
                    $objQuantidades->codigo_equipamento   = $codigo_equipamento;
                    $objQuantidades->nome_equipamento     = $objEquipment->nome;
                    $objQuantidades->quantidade           = $quantidade;
                    $objQuantidades->criado_em            = parent::getNowDateTime();
                    $objQuantidades->atualizado_em        = parent::getNowDateTime();

                    $codigo_quant_equipamento = $objQuantidades->cadastrar();

                    #=============================================
                    # Faz a reducao do estoque
                    #=============================================
                    if($codigo_quant_equipamento != NULL){
                        $objEquipmentQuant = EquipamentosQuantEntity::getQuantitiesById($codigo_quant_equipamento);
                        $QntEquipmet = $objEquipmentQuant->quantidade;

                        $totalEquipamento = $objEquipment->quantidade;

                        $nova_quantidade = (int)$totalEquipamento - (int) $QntEquipmet;
                                
                        $objEquipment->quantidade = $nova_quantidade;
                        $objEquipment->actualizar();
                    }
                }
                
            }else{
                return ErrorController::getError($request);
            }
        }




        public static function getNewEquipmentWithdraw($request, $mensagem = ''){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/equipment/newEquipmentWithdraw',[
                    'navbar'                => parent::getNavbar(),
                    'sidebar'               => parent::getMenu(),
                    'rightsidebar'          => parent::getRightSidebar(),
                    'footer'                => parent::getFooter(),
                    'municaoItem'           => self::getAmmuniationItens($request),
                    'equipmentItem'         => self::getEquipmentItensWidthdraw($request),
                    'mensagem'              => $mensagem
                ]);
                return parent::getPage('SIGECM | Nova Retirada', $content);
            }else{
                return ErrorController::getError($request);
            }
        }
        #============================================================================
        # Funcoes relacionadas aos equipamentos
        #============================================================================



        #============================================================================
        # Funcoes relacionadas a ARECADACAO
        #============================================================================

        //Levantamento do armamento
        private static function getAmmuniationItens($request) {
            $itens = '';
            $results = AmmunitionEntity::getAmmunition(null, 'codigo_municao', null);
            // Iterate through each type
            while ($objAmmunition = $results->fetchObject(AmmunitionEntity::class)) {
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/ammuniationItem', [
                    'codigo'                   => $objAmmunition->codigo_municao,
                    'municao'                  => $objAmmunition->nome
                ]);
            }
            
            return $itens;
        }

        private static function getEquipmentItensWidthdraw($request) {
            $itens = '';
            $results = EquipmentEntity::getEquipments(null, 'codigo_equipamento DESC', null);
            While ($objEquipment = $results->fetchObject(EquipmentEntity::class)){
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/equipmentItem', [
                    'codigo'                => $objEquipment->codigo_equipamento,
                    'equipamento'           => $objEquipment->nome,
                ]);
            }
            return $itens;
        }

        public static function getNewWithdraw($request, $mensagem = ''){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/newWithdraw',[
                    'navbar'                => parent::getNavbar(),
                    'sidebar'               => parent::getMenu(),
                    'rightsidebar'          => parent::getRightSidebar(),
                    'footer'                => parent::getFooter(),
                    'municaoItem'           => self::getAmmuniationItens($request),
                    'equipmentItem'         => self::getEquipmentItensWidthdraw($request),
                    'mensagem'              => $mensagem
                ]);
                return parent::getPage('SIGECM | Nova Retirada', $content);
            }else{
                return ErrorController::getError($request);
            }
        }

        public static function SetNewWithdraw($request){
            if(Funcoes::Permition(1)){
                $file = $request->getFile();
                $postVars = $request->getPostVars();

                $objArrecadacao = new ArrecadacaoEntity;

                #========================================
                # Verificacoes
                #========================================
                # Verificacao se numero de serie nao foi atribuida a outro funcionario
                $where =  "numero_de_serie_arma = ".$postVars['text_numero_serie']." AND data_devolucao is null";
                $results = ArrecadacaoEntity::getArrecadacao($where, 'codigo_arrecadacao DESC', null);
                $objArrecadacaoVerificacao = $results->fetchObject(ArrecadacaoEntity::class);

                if(!empty($objArrecadacaoVerificacao)){
                    $request->getRouter()->redirect('/new-withdraw?status=error_serie');
                }else{
                    #===========================================
                    # Funcionario
                    #===========================================
                    $objArrecadacao->codigo_funcionario             = $postVars['text_codigo'];
                    $objArrecadacao->nome_funcionario               = $postVars['text_full_name'];
                    $objArrecadacao->patente_funcionario            = $postVars['text_patente'];
                    $objArrecadacao->departamento                   = $postVars['text_departamento'];
                    $objArrecadacao->cargo                          = $postVars['text_cargo'];
                    $objArrecadacao->documento_identidade           = $postVars['text_documento'];
                    $objArrecadacao->celular_funcionario            = $postVars['text_celular'];
                    $objArrecadacao->celular_alt                    = $postVars['text_celular_alt'];
                    $objArrecadacao->fotografia                     = $postVars['text_fotografia'];

                    #===========================================
                    # Armamento
                    #===========================================
                    $objArrecadacao->codigo_armamento               = $postVars['text_codigo_armamento'];
                    $objArrecadacao->numero_de_serie_arma           = $postVars['text_numero_serie'];
                    $objArrecadacao->tipo_armamento                 = $postVars['text_tipo_arma'];
                    $objArrecadacao->status_operacional_arma        = $postVars['text_estado'];
                    $objArrecadacao->calibre_municao_arma           = $postVars['text_calibre_municao'];
                    $objArrecadacao->data_ultima_inspecao_arma      = $postVars['text_data_inspencao'];
                    $objArrecadacao->status_operacional_arma        = $postVars['text_estado'];

                    #===========================================
                    # Municoes
                    #===========================================
                    $objArrecadacao->codigo_municao                 = $postVars['text_municao_retirar'];
                    $objArrecadacao->quantidade_municao             = $postVars['text_municao_quantidade'];
                    $objArrecadacao->tipo_armamento                 = $postVars['text_tipo_arma'];


                    #===========================================
                    # Assinaturas
                    #===========================================
                    $objArrecadacao->assinatura_arrecadacao         = $file;
                    $objArrecadacao->data_levantamento              = parent::getNowDate();;
                    $objArrecadacao->criado_em                      = parent::getNowDateTime();
                    $objArrecadacao->atualizado_em                  = parent::getNowDateTime();

                
                    $objArrecadacao->cadastrar();
                    $request->getRouter()->redirect('/withdraw?status=created');
        
                }
                
            }else{
                return ErrorController::getError($request);
            }
        }


        private static function getWithdrawItem($request){
            $itens = '';
            $results = ArrecadacaoEntity::getArrecadacao(null, 'codigo_arrecadacao DESC', null);
            While ($objArrecacao = $results->fetchObject(ArrecadacaoEntity::class)){ 
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/withdrawItem', [
                    'codigo'                => $objArrecacao->codigo_arrecadacao,
                    'nome'                  => $objArrecacao->nome_funcionario,
                    'imagem'                => $objArrecacao->fotografia,
                    'tipo_armamento'        => $objArrecacao->tipo_armamento,
                    'numero'                => $objArrecacao->numero_de_serie_arma,
                    'municoes'              => $objArrecacao->quantidade_municao,
                    'patente'               => $objArrecacao->patente_funcionario,
                    'assinatura'            => $objArrecacao->assinatura_arrecadacao,
                    'telefone'              => $objArrecacao->celular_funcionario,
                    'data_retirada'         => $objArrecacao->data_levantamento
                ]);
            }
            return $itens; 
        }



        public static function getWeaponsInventoryPage($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/weaponWithdraw',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'withdrawItem'  => self::getWithdrawItem($request),
                ]);

                return parent::getPage('SIGECM | Armamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }


        // Devolucao do armamento
        private static function getEquipmentItensReturn($request, $id) {
            $itens = '';
            $results = EquipamentosQuantEntity::getQuantities('codigo_arrecadacao = '.$id, 'codigo_quantidade DESC', null);
            While ($objEquipment = $results->fetchObject(EquipmentEntity::class)){
                $objStatusEquipment = EquipmentEntity::getEquipmentById($objEquipment->codigo_equipamento);
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/equipmentReturnItem', [
                    'codigo'                => $objEquipment->codigo_equipamento,
                    'equipamento'           => $objEquipment->nome_equipamento,
                    'quantidade'            => $objEquipment->quantidade,
                    'estado'                => $objStatusEquipment->estado,
                    'data_levantamento'     => $objEquipment->criado_em,
                ]);
            }
            return $itens;
        }

        public static function getNewWeaponReturn($request, $id){
            if(Funcoes::Permition(1)){
                $objArrecacao = ArrecadacaoEntity::getArrecadacaoById($id);

                $objStatus = StatusArmamentoEntity::getStatusById($objArrecacao->status_operacional_arma);

                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/newWeaponReturn',[
                    'navbar'                => parent::getNavbar(),
                    'sidebar'               => parent::getMenu(),
                    'rightsidebar'          => parent::getRightSidebar(),
                    'footer'                => parent::getFooter(),
                    'fotografia'            => $objArrecacao->fotografia,
                    'fullname'              => $objArrecacao->nome_funcionario,
                    'patente'               => $objArrecacao->patente_funcionario,
                    'departamento'          => $objArrecacao->departamento,
                    'cargo'                 => $objArrecacao->cargo,
                    'documento'             => $objArrecacao->documento_identidade,
                    'assinatura'            => $objArrecacao->assinatura_arrecadacao,
                    'data_levantamento'     => parent::getFormattedDataOnly($objArrecacao->data_levantamento),
                    'gun_code'              => $objArrecacao->codigo_armamento,
                    'gun_serie'             => $objArrecacao->numero_de_serie_arma,
                    'tipo'                  => $objArrecacao->tipo_armamento,
                    'gun_status'            => $objStatus->status,
                    'gun_calibre'           => $objArrecacao->calibre_municao_arma,
                    'gun_data_inspencao'    => $objArrecacao->data_ultima_inspecao_arma,
                    'gun_ammuniation'       => $objArrecacao->quantidade_municao,
                ]);
                return parent::getPage('SIGECM | Devolucao', $content);
            }else{
                return ErrorController::getError($request);
            }
        }  
        
        private static function getEquipmentReturnItem($request, $id) {
            $itens = '';
            $results = EquipamentosQuantEntity::getQuantities('codigo_arrecadacao = '.$id, 'codigo_arrecadacao DESC', null);
            While ($objEquipment = $results->fetchObject(EquipamentosQuantEntity::class)){
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/equipmentItem', [
                    'codigo'                => $objEquipment->codigo_equipamento,
                    'equipamento'           => $objEquipment->nome_equipamento,
                ]);
            }
            return $itens;
        }


        public static function SetNewReturn($request, $id){
            if(Funcoes::Permition(1)){
                $file_fiador = $request->getFile_fiador();
                $file_fiel = $request->getFile_fiel();
                $postVars = $request->getPostVars();




                echo '<pre>';
                print_r($file_fiador);
                print_r($file_fiel);
                print_r($postVars);
                echo $id;
                echo '</pre>';
                exit;
            }else{
                return ErrorController::getError($request);
            }
        }


        private static function getWithdrawItemReturn(){
            $itens = '';
            $results = ArrecadacaoEntity::getArrecadacao(null, 'codigo_arrecadacao DESC', null);
            While ($objArrecacao = $results->fetchObject(ArrecadacaoEntity::class)){ 
                //Montando os itens a serem retornados
                $itens .= ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/weaponReturnItem', [
                    'codigo'                => $objArrecacao->codigo_arrecadacao,
                    'nome'                  => $objArrecacao->nome_funcionario,
                    'imagem'                => $objArrecacao->fotografia,
                    'tipo_armamento'        => $objArrecacao->tipo_armamento,
                    'numero'                => $objArrecacao->numero_de_serie_arma,
                    'municoes'              => $objArrecacao->quantidade_municao,
                    'patente'               => $objArrecacao->patente_funcionario,
                    'assinatura'            => $objArrecacao->assinatura_arrecadacao,
                    'telefone'              => $objArrecacao->celular_funcionario,
                    'data_retirada'         => $objArrecacao->data_levantamento,
                ]);
            }
            return $itens; 
        }

        public static function getWeaponsReturnPage($request){
            if(Funcoes::Permition(1)){
                $content = ViewManager::render('dashboard/modules/arsenalmanagement/weapon_inventory/weaponReturn',[
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'withdrawItemReturn'  => self::getWithdrawItemReturn(),
                ]);

                return parent::getPage('SIGECM | Armamento', $content);
            }else{
                return ErrorController::getError($request);
            }
        }

        #============================================================================
        # fIM Funcoes relacionadas a ARECADACAO
        #============================================================================
    }
?>