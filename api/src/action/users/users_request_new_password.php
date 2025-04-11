<?php

// Importação de classes
use src\controller\mail\Mail;
use src\model\Users;
use src\controller\users\UsersValidate;

// Instânciamento de classes
$Mail = new Mail();
$Users = new Users();
$UsersValidate = new UsersValidate();

// Declaração de variaveis
$result = null;

// Validação do campos de entrada
$UsersValidate->setEmail((string) filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL), null);

// Verifica a existência de erros
if (!empty($UsersValidate->getErrors())) {

    // Result
    $result = [

        'code' => 0,
        'data' => $UsersValidate->getErrors(),

    ];
} else {

    // Busca as configurações do sistema
    $MainGetConfigResult = $Main->GetConfig();

    // Realiza uma busca pelo email informado
    $UsersGetByEmailResult = $Users->GetByEmail($UsersValidate->getEmail());
    ;

    // Verifica se o email existe no banco de dados
    if (!empty($UsersGetByEmailResult->email)) {

        // Guarda o token de redefinição de senha
        $UsersGetByEmailResult->token = bin2hex(random_bytes(32));

        // Guarda o token no banco de dadoss
        $Users->SaveToken($UsersGetByEmailResult->user_id, $UsersGetByEmailResult->token);

        // Inicia a coleta de objetos
        ob_start();

        // Inclusão do layout desejado
        @include_once 'src/view/mail/mail_users_request_new_password_email.php';

        // Obtem o conteudo do arquivo
        $html = ob_get_contents();

        // Remove o arquivo adicionado
        ob_clean();

        // Realiza o envio do email
        $Mail->Send($html, (object)$UsersGetByEmailResult, 'Alteração de Senha: ' . date('d/m/Y H:i:s'), $MainGetConfigResult->mail);

        // Result
        $result = [

            'code' => 200,
            'toast' => [
                [
                    'background' => 'primary',
                    'data' => 'Email de recuperação de senha enviado!'
                ]
            ]

        ];
        
    } else {

        // Result
        $result = [

            'code' => 0,
            'data' => 'Não foi localizado usuário para o email informado',

        ];
    }
}

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
