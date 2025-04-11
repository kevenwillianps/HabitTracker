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
$UsersValidate->setPassword((string) filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS), null);
$UsersValidate->setPasswordConfirm((string) filter_input(INPUT_POST, 'password_confirm', FILTER_SANITIZE_SPECIAL_CHARS), null);
$UsersValidate->setToken((string) filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS));

// Aciono a comparação de senhas
$UsersValidate->comparePassword();

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
    $UsersGetByEmailResult = $Users->GetByToken($UsersValidate->getToken());

    // Verifica se o email existe no banco de dados
    if (!empty($UsersGetByEmailResult->email)) {

        // Guarda o token no banco de dadoss
        $Users->RemoveToken($UsersGetByEmailResult->user_id);
        $Users->SavePassword($UsersGetByEmailResult->user_id, password_hash($UsersValidate->getPassword(), PASSWORD_ARGON2ID));

        // Inicia a coleta de objetos
        ob_start();

        // Inclusão do layout desejado
        @include_once 'src/view/mail/mail_users_info_new_password_email.php';

        // Obtem o conteudo do arquivo
        $html = ob_get_contents();

        // Remove o arquivo adicionado
        ob_clean();

        // Realiza o envio do email
        $Mail->Send($html, (object)$UsersGetByEmailResult, 'Nova senha cadastrada: ' . date('d/m/Y H:i:s'), $MainGetConfigResult->mail);

        // Result
        $result = [

            'code' => 200,
            'toast' => [
                [
                    'background' => 'primary',
                    'data' => 'Senha atualizada com sucesso'
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
