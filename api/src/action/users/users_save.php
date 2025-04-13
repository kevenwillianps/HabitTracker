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
$UsersValidate->setUserId((int) filter_var($INPUT_POST->user_id, FILTER_SANITIZE_NUMBER_INT));
$UsersValidate->setName((string) filter_var($INPUT_POST->name, FILTER_SANITIZE_SPECIAL_CHARS));
$UsersValidate->setEmail((string) filter_var($INPUT_POST->email, FILTER_SANITIZE_EMAIL));
$UsersValidate->setPassword((string) filter_var($INPUT_POST->password, FILTER_SANITIZE_SPECIAL_CHARS));

// Verifico a existência de erros
if (count($UsersValidate->getErrors()) > 0 ) {

    // Result
    $result = [

        'code' => 0,
        'data' => $UsersValidate->getErrors(),

    ];
} else {

    // Efetua um novo cadastro ou atualiza o existente
    if ($Users->Save($UsersValidate)) {

        // Result
        $result = [

            'code' => 200,
            'data' => 'Registro salvo com sucesso!',

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
