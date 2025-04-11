<?php

// Importação de classes
use src\model\Users;
use src\controller\users\UsersValidate;

// Instânciamento de classes
$Users = new Users();
$UsersValidate = new UsersValidate();

// Declaração de variaveis
$result = null;

// Busco todos os registros
$result = $Users->All();

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
