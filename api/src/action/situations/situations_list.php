<?php

// Importação de classes
use src\model\Situations;
use src\controller\situations\SituationsValidate;

// Instânciamento de classes
$Situations = new Situations();
$SituationsValidate = new SituationsValidate();

// Declaração de variaveis
$result = null;

// Busco todos os registros
$result = $Situations->All();

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
