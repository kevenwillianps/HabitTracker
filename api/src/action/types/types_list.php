<?php

// Importação de classes
use src\controller\routers\Router;
use src\model\Types;
use src\controller\types\TypesValidate;

// Verifica se os verbos são iguais
Router::checkVerb('GET', $request->input('request_method'));

// Instânciamento de classes
$Types = new Types();
$TypesValidate = new TypesValidate();

// Declaração de variaveis
$result = null;

// Busco todos os registros
$result = $Types->All();

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
