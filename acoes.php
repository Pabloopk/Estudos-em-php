<?php 

/**
 * Este código PHP é responsável por criar um novo 
 * usuário em um sistema e armazenar os dados no banco 
 * de dados. Ele também inclui o uso de sessões para 
 * fornecer feedback sobre o sucesso ou falha da operação.
 */

/**
 * A função session_start() inicia uma sessão PHP.
 *  As sessões permitem armazenar
 *  informações entre
 *  diferentes páginas da aplicação, como mensagens temporárias ou dados do usuário.
 */
    session_start();

    /**
     * o código inclui o arquivo conexao.php, que contém a lógica para
     *  conectar ao banco de dados. Isso é necessário para executar consultas SQL.
     */
    require 'conexao.php';

    /**
     * Esta linha verifica se o formulário foi submetido.
     *  O $_POST['create_usuario']
     * refere-se 
     * ao nome do botão de submissão do formulário, confirmando que o formulário foi enviado.
     */
    if (isset($_POST['create_usuario'])){

        /**
         * Estas linhas pegam os dados enviados pelo formulário
         *  (nome, e-mail, data de nascimento e senha) e fazem o seguinte:
         * 
         * mysqli_real_escape_string(): protege contra injeção SQL, removendo caracteres especiais.
         */
        $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
        /**
         * trim(): remove espaços em branco no início e no fim da string.
         * password_hash(): criptografa a senha antes de ser armazenada 
         * no banco de dados, tornando-a mais segura.
         */
        $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
        $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
        $senha = isset($_POST['senha']) ? mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT))  : '';
      
        //Aqui, é gerada uma query SQL para inserir os dados capturados no 
        //formulário na tabela usuarios do banco de dados.
        $sql = "INSERT INTO usuarios (nome, email, data_nascimento, senha) VALUES ('$nome', '$email', '$data_nascimento', '$senha')";


        /**
         * A função mysqli_query() executa a query no banco de dados. Em seguida, 
         * mysqli_affected_rows() verifica se alguma linha foi afetada pela operação de inserção 
         * (isto é, se a operação foi bem-sucedida). Se for maior que 0, o usuário 
         * foi criado com sucesso.
         */
        mysqli_query($conexao, $sql);

        /**
         * Dependendo do sucesso ou fracasso da operação, 
         * o usuário é redirecionado para a página index.php e 
         * uma mensagem apropriada é armazenada na sessão
         *  (usada para dar feedback na página de destino).
         */
        
        if (mysqli_affected_rows($conexao) > 0) {
            $_SESSION['mensagem'] = 'Usuário foi criado';

            header('Location: index.php');

            exit;

        } else {
            $_SESSION['mensagem'] = 'Não foi criado';

            /**
             * Se a criação do usuário falhar, 
             * uma mensagem de erro será armazenada na 
             * sessão para ser exibida após o redirecionamento.
             */

            header('Location: index.php');

            exit;
        }
    /**
     * Este código realiza o cadastro de um usuário, inserindo os dados no banco de dados, e 
     * fornece uma mensagem de confirmação ou erro, redirecionando o usuário após a operação.
     */
    }

/**
 * Este código PHP tem duas funcionalidades principais: atualizar e 
 * deletar usuários no banco de dados.
 */
    
    //a função verifica se o formulário de atualização foi enviado.
    // A condição isset($_POST['update_usuario']) é 
    //acionada quando o formulário contendo um botão com o nome update_usuario é submetido.
    if (isset($_POST['update_usuario'])){
        /**
         * Aqui, os dados enviados pelo formulário 
         * são capturados: o ID do usuário, o nome, o email, a data de nascimento e a senha.
         * 
         * mysqli_real_escape_string() é utilizado para evitar ataques de injeção SQL, limpando 
         * qualquer caractere especial.
         * 
         * trim() remove espaços em branco no início e no final dos valores.
         */
        
        $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);

        $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
        $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
        $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
        $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));


        //A query SQL começa a ser construída. Ela vai atualizar os campos nome, email e data_nascimento do registro na tabela usuarios.
        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento'";
                /**
                 * Esta parte do código verifica se o campo da senha não está vazio. 
                 * Se o usuário não forneceu uma nova senha, o campo senha não é atualizado. 
                 * Caso seja fornecida uma nova senha, 
                 * ela é criptografada usando password_hash() e incluída na query de atualização.
                 */
            if (!empty($senha)) {
                $sql .= ", senha='" . password_hash($senha, PASSWORD_DEFAULT) . "'";
            }

            $sql .=" WHERE id = '$usuario_id'";

        //Aqui, a cláusula WHERE é adicionada à query para garantir 
        //que a atualização só seja aplicada ao usuário com o id correspondente.

        //mysqli_query() executa a query de atualização.
        mysqli_query($conexao, $sql);
        
        /**
         * mysqli_affected_rows() verifica se alguma linha foi alterada no banco de dados. 
         * Se o número de linhas afetadas for maior que zero, significa que
         *  a atualização foi bem-sucedida. Caso contrário, não foi realizada nenhuma atualização.
         */

        //Dependendo do resultado, 
        //uma mensagem é armazenada na sessão e o usuário é redirecionado para a página index.php.
        
        if (mysqli_affected_rows($conexao) > 0) {
            $_SESSION['mensagem'] = 'Usuário foi Atualizado';

            header('Location: index.php');

            exit;

        } else {
            $_SESSION['mensagem'] = 'Não foi Atualizado';

            header('Location: index.php');

            exit;
        }

    }

    /**
     * o código verifica se o formulário de exclusão
     *  foi enviado (acionado por um botão com o nome delete_usuario).
     */

    if (isset($_POST['delete_usuario'])) {

        //O ID do usuário que será deletado é capturado e sanitizado para evitar injeções SQL.
        $usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);
        
        //Uma query SQL é criada para remover o 
        //usuário da tabela usuarios, onde o id é igual ao valor capturado.
        $sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";
        
        //mysqli_query() executa a query de exclusão.
        mysqli_query($conexao, $sql);
            /**
             * mysqli_affected_rows() verifica se 
             * alguma linha foi removida. Se for maior que zero, 
             * a exclusão foi bem-sucedida.
             */
            if (mysqli_affected_rows($conexao) > 0) {
                //Dependendo do resultado, uma mensagem apropriada é armazenada na sessão, e o usuário é redirecionado para a página index.php.
                $_SESSION['messagem'] = 'Usuario deletado com sucesso';
                header('Location: index.php');
            } else {
                $_SESSION['messagem'] = 'Usuario nao apagado ';
                header('Location: index.php');
            }
 
    }
?>
