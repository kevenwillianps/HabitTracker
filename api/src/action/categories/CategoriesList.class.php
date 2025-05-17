<?php

// Define o local da classe
namespace src\action\categories;

// Importação de classes
use src\model\Categories;

class CategoriesList
{

    public static function execute()
    {

        // Instânciamento de classes
        $Categories = new Categories();

        // Busco todos os registros
        return $Categories->All();
    }
}
