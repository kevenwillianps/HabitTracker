<?php

// Define o local da classe
namespace src\action\groups;

// Importação de classes
use src\model\Groups;

class GroupsList
{

    public static function execute()
    {

        // Instânciamento de classes
        $Groups = new Groups();

        // Busco todos os registros
        return $Groups->All();
    }
}
