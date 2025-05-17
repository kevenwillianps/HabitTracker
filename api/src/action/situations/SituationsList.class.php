<?php

namespace src\action\situations;

// Importação de classes
use src\model\Situations;

class SituationsList
{

    public static function execute()
    {
        // Instânciamento de classes
        $Situations = new Situations();

        // Busco todos os registros
        return $Situations->All();
    }
}
