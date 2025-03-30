
# [sigecm.gov.mz](https://www.sigecm.gov.mz/)
[![js-standard-style](https://img.shields.io/badge/code%20style-standard-brightgreen.svg?style=flat)](http://standardjs.com/)

O [SIGECM](https://www.sigecm.gov.mz/) é um plataforma de gestao focado em utilizar tecnologia para oferecer serviços de gestao de funcionarios, registar entradas e saidas, gestao da logistica  de maneira mais eficiente, acessível e inovadora.

Esse repositório contém o código-fonte da plataforma e da API.

**Conteúdo**

- [Instalar e rodar o projeto](#instalar-e-rodar-o-projeto)
  - [Requisitos Minimos](#requisitos-minimos)
  - [Preparacao do Ambiente](#preparacao-ambiente)
  - [Clonar o projeto](#clonar-o-projeto)
  - [Criacao da Base de Dados](#criacao-da-base-de-dados)
- [Rodar os testes](#rodar-os-testes)
- [Acessando a base de dados com Workbench](#acessando-base-de-dados-com-workbench)
- [Histórico do desenvolvimento](#histórico-de-desenvolvimento)
  - [Início do projeto](#início-do-projeto)
  - [Milestones](#milestones)


## Instalar e rodar o projeto

Rodar o TabNews em sua máquina local é uma tarefa extremamente simples.

### Requisitos Minimos
Para rodar a plataforma sao necessarios os seguintes requisitos minimos:

- CPU: 4 gigahertz ou mais;
- RAM: 4GB ou mais;
- Armazenamento em Disco: 250 GB ou mais

### Preparacao do Ambiente
Preparacao do ambiente Ubuntu 20.04 + LTS:
- Instalacao do Servidor web Apache
 ```bash
sudo apt update
sudo apt -y upgrade
sudo apt install apache2
```

- Instalacao do Servidor MySQL
 ```bash
sudo apt install mysql-server
```

- Instalacao do PHP 8.2
 ```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt install php8.2
sudo php -v
sudo apt install php8.2-curl php8.2-gd php8.2-intl php8.2-simplexml php8.2-dom php8.2-mysql php8.2-mbstring php8.2-xml php8.2-gd php8.2-curl php8.2-mysqli php8.2-zip
sudo php -m
```

- Actualizacao do ficheiro 000-default.conf
 ```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

 ```bash
<VirtualHost *:80>
    # Define o diretório raiz para o site
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/sigecm

    # Configurações de log
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    # Outras diretivas podem ser configuradas aqui conforme necessário

    # Permitir acesso à pasta
    <Directory /var/www/sigecm>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
 ```bash
sudo systemctl restart apache2
```


### Clonar o projeto

Para clonar o projecto acesse o link :

```bash
https://github.com/cleverdevelopper/fintech.git
```

```bash
cd /var/www
git clone https://github.com/cleverdevelopper/fintech.git
```

```bash
cd /var/www/sigecm
sudo nano .env
```

- Modificar o ficheiro .env do sistema
```bash
URL=http://ip ou dominio
BD_HOST=127.0.0.1
BD_DATABASE=sigecm_database
BD_CHARSET=utf8
DB_PORT=3306
BD_USERNAME=databse_username
BD_PASSWORD=databse_password
MAINTENANCE=false
```

- reiniciar o apache
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Observações:

- Você pode conferir o endereço dos outros serviços dentro do arquivo `.env` encontrado na raiz do projeto, como por exemplo o endereço e credenciais do Banco de Dados local ou o Frontend do Serviço de Email.

### Geracao de certificado ssl
1. Instalar o OpenSSL
Primeiro, verifique se o OpenSSL está instalado no seu servidor. Caso não esteja, instale-o com o seguinte comando:
```bash
sudo apt update
sudo apt install openssl
```
2. Gerar a chave privada
Crie uma chave privada que será usada para gerar o certificado. Você pode gerar uma chave de 2048 bits (tamanho padrão):
```bash
openssl genpkey -algorithm RSA -out /etc/ssl/private/myserver.key -aes256
```
Este comando gera uma chave privada criptografada com AES-256 e a salva em /etc/ssl/private/myserver.key. Você pode substituir o caminho e nome do arquivo conforme necessário.

3. Criar uma Solicitação de Assinatura de Certificado (CSR) — Opcional
Embora você esteja criando um certificado autoassinado, você pode gerar uma solicitação de assinatura de certificado (CSR) se for necessário. Caso contrário, você pode pular este passo.
```bash
openssl req -new -key /etc/ssl/private/myserver.key -out /etc/ssl/myserver.csr
```
Durante este comando, você será solicitado a inserir informações como o nome do país, estado, cidade, nome da organização, e Common Name (CN), que é normalmente o domínio ou IP do servidor.

4. Criar o Certificado Autoassinado
Agora você pode criar o certificado autoassinado usando a chave privada gerada anteriormente:
```bash
openssl req -x509 -key /etc/ssl/private/myserver.key -in /etc/ssl/myserver.csr -out /etc/ssl/certs/myserver.crt -days 365
```
- x509: Isso indica que você está gerando um certificado autoassinado.

- days 365: O certificado será válido por 365 dias. Você pode ajustar esse número conforme necessário.

Isso gerará o certificado autoassinado e o salvará como /etc/ssl/certs/myserver.crt.

5. Verificar o Certificado
Para verificar o conteúdo do certificado gerado, você pode usar:
```bash
openssl x509 -in /etc/ssl/certs/myserver.crt -text -noout
```
## Ativar o módulo SSL no Apache
1. Garantir que o modulo ssl esteja activado
Primeiro, garanta que o módulo SSL do Apache esteja ativado:
```bash
sudo a2enmod ssl
```

2. Criar ou Editar o arquivo de configuração do VirtualHost
A seguir, crie ou edite um arquivo de configuração do Apache para o seu VirtualHost. Normalmente, os arquivos de configuração do Apache para sites ficam em /etc/apache2/sites-available/.

Vamos criar ou editar o arquivo de configuração para o VirtualHost usando o editor de sua escolha (por exemplo, nano):

```bash
sudo nano /etc/apache2/sites-available/ip_do_servidor_ou_dominio.conf
```
No arquivo de configuração, adicione o seguinte conteúdo para configurar o VirtualHost na porta 443:
```bash
<VirtualHost *:443>
    ServerAdmin webmaster@yourdomain.com
    ServerName ip_do_servidor ou dominio
    DocumentRoot /var/www/sigecm

    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/myserver.crt
    SSLCertificateKeyFile /etc/ssl/private/myserver.key

    # Se tiver algum certificado intermediário (opcional)
    #SSLCertificateChainFile /etc/ssl/certs/myserver-chain.crt

    <Directory /var/www/sigecm>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Explicação do arquivo de configuração:
- SSLEngine on: Habilita o SSL para o VirtualHost.

- SSLCertificateFile: Caminho para o seu certificado (gerado com OpenSSL, no exemplo, é /etc/ssl/certs/myserver.crt).

- SSLCertificateKeyFile: Caminho para a chave privada correspondente (no exemplo, /etc/ssl/private/myserver.key).

- SSLCertificateChainFile: Caso tenha um arquivo de cadeia de certificação intermediária, adicione-o aqui. Caso não tenha, pode omitir essa linha.

Substitua os caminhos e domínios pelos corretos para o seu servidor.

3. Ativar o site
Agora, ative o novo arquivo de configuração para o Apache:

```bash
sudo a2ensite ip_do_servidor_ou_dominio.conf
```

4. Verificar se há erros de configuração
Verifique se há algum erro de configuração no Apache:

```bash
sudo apache2ctl configtest
```
Se o comando retornar Syntax OK, significa que a configuração está correta.

5. Reiniciar o Apache
Para aplicar as alterações, reinicie o Apache:
```bash
sudo systemctl restart apache2
```

6. Acessar o site via HTTPS
Agora, ao acessar seu domínio https://ip_do_servidor_ou_dominio.com no navegador, o Apache deve servir o conteúdo do diretório /var/www/html usando HTTPS.

7. Dica adicional:
Se você quiser redirecionar automaticamente as requisições HTTP (porta 80) para HTTPS (porta 443), você pode configurar outro VirtualHost para a porta 80 e adicionar um redirecionamento para HTTPS:

Exemplo de configuração para o VirtualHost na porta 80 (HTTP):
```bash
<VirtualHost *:80>
    ServerAdmin webmaster@ip_do_servidor_ou_dominio
    ServerName ip_do_servidor_ou_dominio
    Redirect permanent / https://ip_do_servidor_ou_dominio/
</VirtualHost>
```
Isso garantirá que qualquer tentativa de acessar o site via HTTP seja automaticamente redirecionada para HTTPS.

### Cadastro e Login de usuários

No ambiente de desenvolvimento você poderá tanto criar usuários manualmente (inclusive para receber e testar o email de ativação), quanto utilizar usuários pré-cadastrados e que já foram ativados para sua conveniência.

1. Após a clonagem do repositorio e a configuracao do .env
2. Cria-se a base de dados de acordo com o ficheiro .sql da raiz do projecto criando as tabelas e os trigers e as insercoes.


```bash
sudo mysql
CREATE DATABASE example_database;
CREATE USER 'example_user'@'%' IDENTIFIED WITH mysql_native_password BY 'password';
GRANT ALL ON example_database.* TO 'example_user'@'%';
exit
```

Acessando o mysql com o novo user
```bash
mysql -u example_user -p
```

Em seguida, criaremos as tabela.s A partir do console do MySQL, execute os comandos do ficheiro sql

## Rodar os testes

Há várias formas de rodar os testes dependendo do que você deseja fazer, mas o primeiro passo antes de fazer qualquer alteração no projeto é rodar os testes de forma geral para se certificar que tudo está passando como esperado.

## Acessando a base de dedos com Workbench
Primeiro entrar no servidor e rodar o seguinte comando
```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

Em seguida, alterar o ip do bind-address para um ip em especifico ou para geral
```bash
bind-address = 127.0.0.1 #Alterar este ip
bind-address = 0.0.0.0 # ou bind-address = 192.168.x.x
```
### Configurando o mysql para aceitar a conexoes externas
Faça login no MySQL com o comando:
```bash
sudo mysql -u root -p
```

Criar o usuário root para %:
```bash
CREATE USER 'root'@'%' IDENTIFIED BY 'senha';
```
Conceder permissões ao usuário root:
```bash
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```
Verificar as permissoes:
```bash
SHOW GRANTS FOR 'root'@'%';
```

Alterar a senha (se necessário):
```bash
ALTER USER 'root'@'%' IDENTIFIED BY 'senha';
exit
```


Reiniciar o mysql:
```bash
sudo systemctl restart mysql
```

Agora atraves de um computador que esteja na rede sera possivel aceder ao mysql do servidor a atraves do Workbench


## Histórico de Desenvolvimento

### Início do projeto

No início do projeto foram feitos brainstorms sobre o projecto que culminaram com o levantamento e analise dos requisitos do Sistema. Netes brainstorms colheu-se informações desde como a ideia iniciais do Fintech as contribuições no início do projeto, até as definições do layout e outras tomadas de decisão.

### Milestones

Milestones são marcos históricos do projeto para ajudar a guiar o desenvolvimento numa direção específica. 


Em caso do composer de ocorrer erros entre o php 8.2 e o 7.*
```bash
sudo apt-get purge php7.*
```


