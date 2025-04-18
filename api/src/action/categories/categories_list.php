<?php

// Importação de classes
use src\model\Categories;
use src\controller\categories\CategoriesValidate;

// Instânciamento de classes
$Categories = new Categories();
$CategoriesValidate = new CategoriesValidate();

// Declaração de variaveis
$result = null;

// Busco todos os registros
$result = $Categories->All();

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
