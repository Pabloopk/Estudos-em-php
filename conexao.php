<?php 

//Este código PHP define constantes para a conexão com um banco de dados MySQL
// e estabelece essa conexão usando a extensão mysqli.

//A função define() cria constantes que serão usadas 
//para armazenar as informações necessárias para se conectar ao banco de dados
define('HOST', '127.0.0.1');
//O endereço do servidor de banco de dados. Neste caso, é '127.0.0.1', que corresponde ao servidor local (localhost).

define('USUARIO','root');
//O nome de usuário do banco de dados, que aqui está definido como 'root', o nome de usuário padrão no MySQL para o administrador.

define('SENHA', '');
// senha do usuário do banco de dados. Neste caso, está vazia (''), o que é comum em 
//ambientes de desenvolvimento onde não é configurada uma senha para o usuário root.

define('DB', 'crudti');
// O nome do banco de dados ao qual
// você está se conectando. Aqui, o banco de dados é chamado 'crudti'.

$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ('corno tentando conectar');
/**
 * mysqli_connect(HOST, USUARIO, SENHA, DB): Esta função tenta 
 * estabelecer uma conexão com o banco de dados
 *  MySQL usando as informações fornecidas (host, usuário, senha e nome do banco de dados).
 * 
 * Se a conexão for bem-sucedida, a variável $conexao conterá a conexão ao banco de dados, que pode ser usada para executar consultas.
 * Caso a conexão falhe, a função or die('corno tentando conectar') será executada, interrompendo o script e exibindo a mensagem de erro. Essa mensagem é personalizada, e o ideal seria 
 * usar uma mensagem mais informativa e amigável (como "Falha na conexão com o banco de dados").
 */

//Este código define as informações de conexão (servidor, usuário, senha e nome do banco de dados) e tenta se conectar ao banco de dados MySQL.
?>
