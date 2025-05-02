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
$GroupsValidate->setGroupId((int) $request->input('group_id'));

// Verifico a existência de erros
if (count($GroupsValidate->getErrors()) > 0) {

    // Mensagem de erro
    throw new Exception(json_encode($GroupsValidate->getErrors()));
} else {

    // Busca o registro desejado
    $GroupsGetResult = $Groups->get($GroupsValidate);

    // Verifico a existência do registro
    if ($GroupsGetResult->group_id > 0) {

        // Result
        $result = [

            'code' => 200,
            'data' => $GroupsGetResult,

        ];
    } else {

        // Retorno da mensagem de erro
        throw new InvalidArgumentException('Não foi possivel localizar o registro', 0);
    }
}

// Envio dos dados
echo json_encode($result);

// Encerro o procedimento
exit;
