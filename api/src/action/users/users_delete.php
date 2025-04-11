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

// Verifico a existência de erros
if (!empty($UsersValidate->getErrors())) {

    // Result
    $result = [

        'code' => 0,
        'data' => $UsersValidate->getErrors(),

    ];
} else {

    // Busca o registro informado
    $UsersGetResult = $Users->Get($UsersValidate->getUserId());

    // Verifica se o arquivo foi encontrado
    if ($UsersGetResult->user_id > 0) {

        // Efetua um novo cadastro ou atualiza o existente
        if ($Users->Delete($UsersValidate->getUserId())) {

            // Result
            $result = [

                'code' => 200,
                'data' => 'Perfil Atualizado',
                'toast' => [
                    [
                        'background' => 'primary',
                        'data' => 'Usuário removido!'
                    ]
                ],
                'procedure' => [
                    [
                        'name' => 'removeElementById',
                        'options' => [
                            'elementId' => 'User' . $UsersValidate->getUserId(),
                        ]
                    ]
                ]

            ];
        } else {

            // Retorno da mensagem de erro
            throw new InvalidArgumentException('Não foi possivel remover o registro', 0);
        }
    } else {

        // Result
        $result = [

            'code' => 200,
            'toast' => [
                [
                    'background' => 'danger',
                    'data' => 'Usuário não localizado!'
                ]
            ]

        ];
    }
}

// Envio dos dados
echo json_encode($result);

// Encerro o procedimento
exit;
