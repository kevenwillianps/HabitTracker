<?php

// Importação de classes
use src\model\Groups;
use src\controller\groups\GroupsValidate;

// Instânciamento de classes
$Groups = new Groups();
$GroupsValidate = new GroupsValidate();

// Declaração de variaveis
$result = null;

// Busco todos os registros
$result = $Groups->All();

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
