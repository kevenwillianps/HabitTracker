<?php

// Importação de classes
use src\model\Categories;
use src\controller\categories\CategoriesValidate;

// Instâncimento de classes
$Categories = new Categories();
$CategoriesValidate = new CategoriesValidate();

// Controle de resultados
$result = null;

// Validação do campos de entrada
$CategoriesValidate->setCategoryId((int) filter_var($INPUT_POST->category_id, FILTER_SANITIZE_NUMBER_INT));
$CategoriesValidate->setName((string) filter_var($INPUT_POST->name, FILTER_SANITIZE_SPECIAL_CHARS));

// Verifico a existência de erros
if (count($CategoriesValidate->getErrors()) > 0 ) {

    // Mensagem de erro
    throw new Exception(json_encode($CategoriesValidate->getErrors()));

} else {

    // Efetua um novo cadastro ou atualiza o existente
    if ($Categories->save($CategoriesValidate)) {

        // Result
        $result = [

            'code' => 200,
            'data' => 'Registro salvo com sucesso!',

        ];
    } else {

        // Retorno da mensagem de erro
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);
    }
}

// Envio dos dados
echo json_encode($result);

// Encerro o procedimento
exit;
