<?php

// Importação de classes
use src\model\Habits;
use src\controller\habits\HabitsValidate;

// Instânciamento de classes
$Habits = new Habits();
$HabitsValidate = new HabitsValidate();

// Declaração de variaveis
$result = null;

// Busco todos os registros
$result = $Habits->All();

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
