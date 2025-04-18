<?php

// Importação de classes
use src\model\Groups;
use src\controller\groups\GroupsValidate;

// Instâncimento de classes
$Groups = new Groups();
$GroupsValidate = new GroupsValidate();

// Controle de resultados
$result = null;

// Validação do campos de entrada
$GroupsValidate->setGroupId((int) filter_var($INPUT_POST->group_id, FILTER_SANITIZE_NUMBER_INT));
$GroupsValidate->setName((string) filter_var($INPUT_POST->name, FILTER_SANITIZE_SPECIAL_CHARS));

// Verifico a existência de erros
if (count($GroupsValidate->getErrors()) > 0 ) {

    // Mensagem de erro
    throw new Exception(json_encode($GroupsValidate->getErrors()));

} else {

    // Efetua um novo cadastro ou atualiza o existente
    if ($Groups->save($GroupsValidate)) {

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
