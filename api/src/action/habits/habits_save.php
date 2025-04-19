<?php

// Importação de classes
use src\model\Habits;
use src\controller\habits\HabitsValidate;

// Instâncimento de classes
$Habits = new Habits();
$HabitsValidate = new HabitsValidate();

// Controle de resultados
$result = null;

// Validação do campos de entrada
$HabitsValidate->setHabitId((int) filter_var($INPUT_POST->habit_id, FILTER_SANITIZE_NUMBER_INT));
$HabitsValidate->setSituationId((int) filter_var($INPUT_POST->situation_id, FILTER_SANITIZE_NUMBER_INT));
$HabitsValidate->setGroupId((int) filter_var($INPUT_POST->group_id, FILTER_SANITIZE_NUMBER_INT));
$HabitsValidate->setCategoryId((int) filter_var($INPUT_POST->category_id, FILTER_SANITIZE_NUMBER_INT));
$HabitsValidate->setTypeId((int) filter_var($INPUT_POST->type_id, FILTER_SANITIZE_NUMBER_INT));
$HabitsValidate->setUserId(1);
$HabitsValidate->setName(filter_var($INPUT_POST->name, FILTER_SANITIZE_SPECIAL_CHARS));
$HabitsValidate->setDescription(filter_var($INPUT_POST->description, FILTER_SANITIZE_SPECIAL_CHARS));
$HabitsValidate->setUrl(filter_var($INPUT_POST->url, FILTER_SANITIZE_SPECIAL_CHARS));
$HabitsValidate->setStartsIn(filter_var($INPUT_POST->starts_in, FILTER_SANITIZE_SPECIAL_CHARS));
$HabitsValidate->setEndsIn(filter_var($INPUT_POST->ends_in, FILTER_SANITIZE_SPECIAL_CHARS));

// Verifico a existência de erros
if (count($HabitsValidate->getErrors()) > 0 ) {

    // Mensagem de erro
    throw new Exception(json_encode($HabitsValidate->getErrors()));

} else {

    // Efetua um novo cadastro ou atualiza o existente
    if ($Habits->save($HabitsValidate)) {

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
