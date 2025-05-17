<?php

// Define o local da classe
namespace src\action\types;

// Importação de classes
use src\controller\routers\Router;
use src\model\Types;

class TypesList
{

    public static function execute(Router $request)
    {

        // Verifica se os verbos são iguais
        Router::checkVerb('GET', $request->input('request_method'));

        // Declaração de variaveis
        return Types::all();
    }
}
