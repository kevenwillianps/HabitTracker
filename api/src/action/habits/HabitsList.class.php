<?php

namespace src\action\habits;

// Importação de classes
use src\model\Habits;

class HabitsList
{

    public static function execute()
    {
        // Instânciamento de classes
        $Habits = new Habits();

        // Declaração de variaveis
        return $Habits->All();
    }
}
