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
$UsersValidate->setUserId((int) filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT));
$UsersValidate->setCompanyId((int) filter_input(INPUT_POST, 'company_id', FILTER_SANITIZE_NUMBER_INT));
$UsersValidate->setName((string) filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$UsersValidate->setEmail((string) filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL), 'email');
$UsersValidate->setPassword((string) filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS), 'password');
$UsersValidate->setPosition((string) filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS));
$UsersValidate->setTeam((string) filter_input(INPUT_POST, 'team', FILTER_SANITIZE_SPECIAL_CHARS));

// Verifico a existência de erros
if (!empty($UsersValidate->getErrors())) {

    // Result
    $result = [

        'code' => 0,
        'data' => $UsersValidate->getErrors(),

    ];
} else {

    // Efetua um novo cadastro ou atualiza o existente
    if ($Users->Save(
        $UsersValidate->getUserId(),
        $UsersValidate->getCompanyId(),
        $UsersValidate->getName(),
        $UsersValidate->getEmail(),
        $UsersValidate->hashPassword(),
        $UsersValidate->getPosition(),
        $UsersValidate->getTeam()
    )) {

        // Result
        $result = [

            'code' => 200,
            'toast' => [
                [
                    'background' => 'primary',
                    'data' => 'Usuário salvo!'
                ]
            ],
            'redirect' => [
                [
                    'request' => 'view/users/users_index',
                    'target' => null,
                    'params' => null,
                    'loader' => [
                        'type' => 2
                    ]
                ]
            ]

        ];
    } else {

        // Retorno da mensagem de erro
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);
    }
}

// Envio dos dados
echo json_encode($result);

// Encerro o procedimento
exit;
