# WDSApp

**Plataforma de código fonte aberto destinada ao estudo e prática de técnicas de segurança no desenvolvimento de aplicações web no curso WebDevSec da Desec Security**

## Requisitos
- Servidor: **Apache 2.4.xx**;
- Banco de dados: **MySQL 5.xx** ou superior;
- Linguagem Principal: **PHP 7.1.xx** ou superior;
- Linguagem complementar: **Javascript**;
- Endereço de e-mail com permissão de envio de mensagens através do protocolo **SMTP**.
- **IDE PHP**


## Configuração Inicial
A configuração Inicial trata de obter os requisitos mínimos para o acesso à aplicação WDSApp e realização dos exercícios propostos no treinamento.

>**Caso você já possua um servidor web configurado em seu ambiente local, um endereço de e-mail que possa ser utilizado para enviar mensagens através da aplicação e uma IDE que suporte a linguagem PHP e Javascript, pule para [Instalação](#instalação).**

### Servidor Apache, MySQL e PHP
- Faça o download e instalação do app de sua preferência para configuração do servidor local:
  - MAMP (https://www.mamp.info)
  - XAMPP (https://www.apachefriends.org)

### Endereço de e-mail
- Crie uma conta de e-mail gratuita no Gmail (https://gmail.com) ou similar.

### IDE PHP / Javascript
- Faça o download e instalação da IDE de sua preferência:
  - Visual Studio Code (https://code.visualstudio.com)
  - Sublime Text (https://www.sublimetext.com)

## Instalação
### Arquivos
- Faça o download dos arquivos deste **[Respositório](./)** para uma pasta **/wdsapp** dentro do seu servidor local (Ex.: **../htdocs/wdsapp**) para acesso à aplicação via browser no endereço:  http://localhost/wdsapp.
    >Sinta-se livre para configurar a aplicação em um endereço diferente.

- Através de sua IDE, acesse o arquivo **.htaccess** localizado na raiz da aplicação **(../wdsapp/.htaccess)**;
    >Este é um arquivo oculto e poderá ser visualizado apenas através de sua IDE, não podendo ser visualizado no explorer ou gerenciados de pastas do seu sistema operacional, ao menos que você configure seu sistema para permitir a visualização de arquivos ocultos. 
- Caso necessário, altere o caminho da aplicação de acordo com o local onde você publicou os arquivos em seu servidor local.

  ```
    RewriteBase /wdsapp/
  ```


- Através de sua IDE, acesse o arquivo **/config/app.php** e caso necessário altere o HOST da aplicação assim como o endereço da imagem do logotipo da aplicação de acordo com o local onde você publicou os arquivos em seu servidor local:
    ```
      define('_HOST_','http://localhost/wdsapp/');
      define('_LOGO_','http://localhost/wdsapp/imgs/logo_app.jpg');
    ```


### Banco de dados

- Para a criação da base dados utilizada pela aplicação, importe o arquivo **wdsapp/sql/wdsapp.sql** através do PhpMyAdmin (Ex.: **http://localhost/phpmyadmin**) ou outro gerenciador de banco de dados que você utilize.


- Acesse a tabela **config** na base de dados criada (Ex.: http://localhost/phpmyadmin/?db=devsec_wdsapp_db) e informe as credeciais do endereço de e-mail que será utilizado para o envio de mensagens através da aplicação. 

    | mailuser                | mailpass | smtphost         | smtpsecure | smtpport   |
    |-------------------------|----------|------------------|------------|------------|
    | seuemail@dominio.com    | password | smtp.dominio.com | tls ou ssl | 587 ou 465 |
    
    >As credenciais de e-mail, assim como as configurações SMTP devem ser obtidas junto ao provedor do serviço de emails utilizado.
    > Para conhecimento, os serviços de e-mail geralmente utilizam segurança:
    > 
    > TLS / porta 587 (**smtpsecure: tls / smtpport: 587**) <sup>*mais utilizado</sup>
    > 
    > SSL / porta 465 (**smtpsecure: ssl / smtpport: 465**)
   
  Exemplo de configuração para emails Gmail:

    | mailuser           | mailpass | smtphost       | smtpsecure     | smtpport       |
    |--------------------|----------|----------------|----------------|----------------|
    | seuemail@gmail.com | password | smtp.gmail.com | tls            | 587            |

- Através de sua IDE, acesse o arquivo **/config/config.php** e caso necessário altere as informações de conexão com o banco de dados de acordo com seu ambiente local:
    
    ```
    class config{
     var $host = 'localhost';
     var $user = 'root';
     var $pass = 'root';
     var $db = 'devsec_wdsapp_db';
    }
    ```

    >O App MAMP utiliza as credenciais user: **root e password: root** por padrão para acesso ao MySQL enquanto o XAMPP utiliza o **user: root sem password** definido, mas isso pode variar de acordo a versão do App instalado ou de acordo com as configurações realizadas em seu servidor local.
    >Caso esteja utilizando o XAMPP, o seu arquivo **/config/config.php** deve ser editado para que a variável **$pass** fique em branco:
       
    ```
    class config{
     var $host = 'localhost';
     var $user = 'root';
     var $pass = '';
     var $db = 'devsec_wdsapp_db';
    }
    ```


  
## Credenciais de Acesso



- ### Painel Administrativo: **http://localhost/wdsapp**

  **Usuário Administrador**
  
    | user                  | password |
    |--------------------|--------------------|
    | admin@alexrosa.dev  | admin1234@ |
 
  **Usuário Colaborador**

    | user                 | password     |
    |----------------------|--------------|
    | usuario@alexrosa.dev | usuario1234@ |
  

- ### Área do Cliente: **http://localhost/wdsapp/acesso**

    | user                 | password             |
    |----------------------|---------|
    | cliente@alexrosa.dev | 123456               |
  
