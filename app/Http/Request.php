<?php
    #=================================================
    # REQUEST QUE NAO SUPORTA API
    #=================================================
    namespace App\Http;

    class Request{
        private $httpMethod;
        private $uri;
        private $queryParams = [];
        private $postVars = [];
        private $headers = [];
        private $router;
        private $file;
        private $file_fiador;
        private $file_fiel;

        public function __construct($router)
        {
            $this->router          = $router;
            $this->httpMethod      = $_SERVER['REQUEST_METHOD'] ?? '';
            $this->setUri();
            $this->queryParams     = $_GET ?? [];
            $this->setPostVars();
            $this->headers         = getallheaders();
        }

        private function setPostVars(){
            if(isset($_FILES['imagem'])){
                $img_name = $_FILES['imagem']['name'];
                $tmp_name = $_FILES['imagem']['tmp_name'];

                $time = time();
                $new_image_name = $time.$img_name;
                move_uploaded_file($tmp_name, "images/".$new_image_name);

                $this->file = $new_image_name;
                $this->postVars        = $_POST ?? [];
            }elseif(isset($_FILES['signature_image'])){
                #=========================================================
                # Condicao responsavel por guardar as assinaturas
                #=========================================================
                $img_name = $_FILES['signature_image']['name'];
                $tmp_name = $_FILES['signature_image']['tmp_name'];

                $time = time();
                $new_image_name = $time.$img_name;
                move_uploaded_file($tmp_name, "images/Signatures/".$new_image_name);

                $this->file = $new_image_name;
                $this->postVars        = $_POST ?? [];

            }elseif(isset($_FILES['signature_image_equipment'])){
                #=========================================================
                # Condicao responsavel por guardar as assinaturas
                #=========================================================
                $img_name = $_FILES['signature_image_equipment']['name'];
                $tmp_name = $_FILES['signature_image_equipment']['tmp_name'];

                $time = time();
                $new_image_name = $time.$img_name;
                move_uploaded_file($tmp_name, "images/EquipmentSignatures/".$new_image_name);

                $this->file = $new_image_name;
                $this->postVars        = $_POST ?? [];

            }elseif (isset($_FILES['signature_image_fiador']) || isset($_FILES['signature_image_fiel'])) {
                #=========================================================
                # Condição responsável por guardar as assinaturas
                #=========================================================
            
                // Verifica se a assinatura do Fiador foi enviada
                if (isset($_FILES['signature_image_fiador'])) {
                    $img_name_fiador = $_FILES['signature_image_fiador']['name'];
                    $tmp_name_fiador = $_FILES['signature_image_fiador']['tmp_name'];
            
                    $time = time();
                    $new_image_name_fiador = $time . "_fiador_" . $img_name_fiador; // Adiciona um prefixo para identificar a assinatura do Fiador
                    move_uploaded_file($tmp_name_fiador, "images/Signatures/" . $new_image_name_fiador);
            
                    // Armazena o nome do arquivo da assinatura do Fiador
                    $this->file_fiador = $new_image_name_fiador;
                }
            
                // Verifica se a assinatura do Fiel foi enviada
                if (isset($_FILES['signature_image_fiel'])) {
                    $img_name_fiel = $_FILES['signature_image_fiel']['name'];
                    $tmp_name_fiel = $_FILES['signature_image_fiel']['tmp_name'];
            
                    $time = time();
                    $new_image_name_fiel = $time . "_fiel_" . $img_name_fiel; // Adiciona um prefixo para identificar a assinatura do Fiel
                    move_uploaded_file($tmp_name_fiel, "images/Signatures/" . $new_image_name_fiel);
            
                    // Armazena o nome do arquivo da assinatura do Fiel
                    $this->file_fiel = $new_image_name_fiel;
                }
            
                // Armazena os dados do POST
                $this->postVars = $_POST ?? [];
            }else{
                $this->postVars        = $_POST ?? [];
            }

        }
        
        private function setUri(){
            $this->uri = $_SERVER['REQUEST_URI'] ?? '';
            $xURI = explode('?', $this->uri);
            $this->uri = $xURI[0];
        }

        public function getHttpMethod(){
            return $this->httpMethod;
        }

        public function getUri(){
            return $this->uri;
        }

        public function getQueryParams(){
            return $this->queryParams;
        }

        public function getPostVars(){
            return $this->postVars;
        }

        public function getHeaders(){
            return $this->headers;
        }

        public function getRouter(){
            return $this->router;
        }

        public function getFile(){
            return $this->file;
        }
        public function getFile_fiador(){
            return $this->file_fiador;
        }
        public function getFile_fiel(){
            return $this->file_fiel;
        }
    }

?>
