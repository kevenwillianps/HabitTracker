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

// Verifico a existência de erros
if (count($HabitsValidate->getErrors()) > 0) {

    // Mensagem de erro
    throw new Exception(json_encode($HabitsValidate->getErrors()));
} else {

    // Busca o registro desejado
    $HabitsGetResult = $Habits->get($HabitsValidate);

    // Verifico a existência do registro
    if ($HabitsGetResult->habit_id > 0) {

        // Result
        $result = [

            'code' => 200,
            'data' => $HabitsGetResult,

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
