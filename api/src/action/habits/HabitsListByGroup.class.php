<?php

namespace src\action\habits;

// Importação de classes
use src\model\Habits;
use src\controller\habits\HabitsValidate;
use src\controller\routers\Router;

class HabitsListByGroup
{

    public static function execute(Router $request)
    {

        // Instânciamento de classes
        $Habits = new Habits();
        $HabitsValidate = new HabitsValidate();

        // Parâmetros de entrada
        $HabitsValidate->setGroupId($request->input('group_id'));

        // Busco todos os registros
        return $Habits->all();
    }
}
