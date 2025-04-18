<?php

// Importação de classes
use src\model\Types;
use src\controller\types\TypesValidate;

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
