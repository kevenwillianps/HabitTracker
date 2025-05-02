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
$HabitsValidate->setHabitId($request->input('habit_id'));
$HabitsValidate->setSituationId($request->input('situation_id'));
$HabitsValidate->setGroupId($request->input('group_id'));
$HabitsValidate->setCategoryId($request->input('category_id'));
$HabitsValidate->setTypeId($request->input('type_id'));
$HabitsValidate->setUserId(1);
$HabitsValidate->setName($request->input('name'));
$HabitsValidate->setDescription($request->input('description'));
$HabitsValidate->setUrl($request->input('url'));
$HabitsValidate->setStartsIn($request->input('starts_in'));
$HabitsValidate->setEndsIn($request->input('ends_in'));

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
