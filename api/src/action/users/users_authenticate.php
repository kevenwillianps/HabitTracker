<?php

// Importação de classes
use src\model\Users;
use src\controller\users\UsersValidate;

// Instâncimento de classes
$Users = new Users();
$UsersValidate = new UsersValidate();

// Controle de resultados
$result = null;

// Validação do campos de entrada
$UsersValidate->setEmail((string) filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS));
$UsersValidate->setPassword((string) filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));

// Verifico a existência de erros
if (!empty($UsersValidate->getErrors())) {

    // Result
    $result = [

        'code' => 0,
        'data' => $UsersValidate->getErrors(),

    ];

} else {

    // Busco o email informado
    $UsersGetByEmailResult = $Users->GetByEmail($UsersValidate->getEmail());

    // Verifico se o email informado foi localizado
    if (!empty($UsersGetByEmailResult->email)) {

        // Verifico se as senhas são iguais
        if (password_verify($UsersValidate->getPassword(), $UsersGetByEmailResult->password)) {

            // Inicialização da sessão
            session_start();

            // Defino os valores da sessão
            $_SESSION[$MainGetConfigResult->session->name] = $UsersGetByEmailResult;

            // Result
            $result = [

                'code' => 200,
                'toast' => [
                    [
                        'background' => 'primary',
                        'data' => 'Usuário localizado!'
                    ]
                ],
                'procedure' => [
                    [
                        'name' => 'HideModal',
                        'options' => [
                            'target' => 'CallActivityContextMenuZone'
                        ]
                    ]
                ]

            ];

        } else {

            // Result
            $result = [

                'code' => 0,
                'data' => 'Senha inválida',

            ];

        }

    } else {

        // Result
        $result = [

            'code' => 0,
            'data' => 'Não foi localizado usuário para o email informado',

        ];

    }

}

// Envio dos dados
echo json_encode($result);

// Encerro o procedimento
exit;
