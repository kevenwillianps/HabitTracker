<?php

// Importação de classes
use src\model\Situations;
use src\controller\Situations\SituationsValidate;

// Instâncimento de classes
$Situations = new Situations();
$SituationsValidate = new SituationsValidate();

// Controle de resultados
$result = null;

// Validação do campos de entrada
$SituationsValidate->setSituationId((int) filter_var($INPUT_POST->situation_id, FILTER_SANITIZE_NUMBER_INT));
$SituationsValidate->setName((string) filter_var($INPUT_POST->name, FILTER_SANITIZE_SPECIAL_CHARS));
$SituationsValidate->setDescription((string) filter_var($INPUT_POST->description, FILTER_SANITIZE_EMAIL));

// Verifico a existência de erros
if (count($SituationsValidate->getErrors()) > 0 ) {

    // Mensagem de erro
    throw new Exception(json_encode($SituationsValidate->getErrors()));

} else {

    // Efetua um novo cadastro ou atualiza o existente
    if ($Situations->save($SituationsValidate)) {

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
