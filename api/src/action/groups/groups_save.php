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
$GroupsValidate->setName($request->input('name'));
$GroupsValidate->setPreferences($request->input('preferences'));

// Verifico a existência de erros
if (count($GroupsValidate->getErrors()) > 0) {

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
