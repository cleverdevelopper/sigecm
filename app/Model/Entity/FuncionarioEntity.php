<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class FuncionarioEntity{
        public $codigo_funcionario;
        public $nome_completo;
        public $data_nascimento;
        public $genero;
        public $documento_identidade; 
        public $patente; 
        public $endereco; 
        public $celular; 
        public $celular_alt; 
        public $email; 
        public $data_admissao; 
        public $data_fim_comissao; 
        public $codigo_departamento; 
        public $nome_departamento; 
        public $codigo_cargo; 
        public $cargo; 
        public $cargo_descricao; 
        public $salario_base; 
        public $fotografia; 
        public $criado_em;
        public $atualizado_em;
        public $apagado_em;  
        
        
        public  function cadastrar(){
            $this->codigo_funcionario = (new Database('funcionarios'))->insert([
                'nome_completo'             => $this->nome_completo,
                'data_nascimento'           => $this->data_nascimento,
                'genero'                    => $this->genero,
                'documento_identidade'      => $this->documento_identidade,
                'patente'                   => $this->patente,
                'endereco'                  => $this->endereco,
                'celular'                   => $this->celular,
                'celular_alt'               => $this->celular_alt,
                'email'                     => $this->email,
                'data_admissao'             => $this->data_admissao,
                'data_fim_comissao'         => $this->data_fim_comissao,
                'codigo_departamento'       => $this->codigo_departamento,
                'nome_departamento'         => $this->nome_departamento,
                'codigo_cargo'              => $this->codigo_cargo,
                'cargo'                     => $this->cargo,
                'cargo_descricao'           => $this->cargo_descricao,
                'salario_base'              => $this->salario_base,
                'fotografia'                => $this->fotografia,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
            return $this->codigo_funcionario;
        }

        public static function getFuncionario($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('funcionarios'))->select($where, $order, $limit, $fields);
        }

        public static function getFuncionarioById($id){
            return self::getFuncionario('codigo_funcionario = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('funcionarios'))->update('codigo_funcionario = '.$this->codigo_funcionario, [
                'nome_completo'             => $this->nome_completo,
                'data_nascimento'           => $this->data_nascimento,
                'genero'                    => $this->genero,
                'documento_identidade'      => $this->documento_identidade,
                'patente'                   => $this->patente,
                'endereco'                  => $this->endereco,
                'celular'                   => $this->celular,
                'celular_alt'               => $this->celular_alt,
                'email'                     => $this->email,
                'data_admissao'             => $this->data_admissao,
                'data_fim_comissao'         => $this->data_fim_comissao,
                'codigo_departamento'       => $this->codigo_departamento,
                'nome_departamento'         => $this->nome_departamento,
                'codigo_cargo'              => $this->codigo_cargo,
                'cargo'                     => $this->cargo,
                'cargo_descricao'           => $this->cargo_descricao,
                'salario_base'              => $this->salario_base,
                'fotografia'                => $this->fotografia,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em
            ]);
        }

    }
?>