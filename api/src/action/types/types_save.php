<?php

// Importação de classes
use src\model\Types;
use src\controller\types\TypesValidate;

// Instâncimento de classes
$Types = new Types();
$TypesValidate = new TypesValidate();

// Controle de resultados
$result = null;

// Validação do campos de entrada
$TypesValidate->setTypeId((int) filter_var($INPUT_POST->type_id, FILTER_SANITIZE_NUMBER_INT));
$TypesValidate->setName((string) filter_var($INPUT_POST->name, FILTER_SANITIZE_SPECIAL_CHARS));
$TypesValidate->setDescription((string) filter_var($INPUT_POST->description, FILTER_SANITIZE_EMAIL));

// Verifico a existência de erros
if (count($TypesValidate->getErrors()) > 0 ) {

    // Mensagem de erro
    throw new Exception(json_encode($TypesValidate->getErrors()));

} else {

    // Efetua um novo cadastro ou atualiza o existente
    if ($Types->save($TypesValidate)) {

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
