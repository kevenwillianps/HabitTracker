<?php

// Exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Importação do Autoload lado servidor
require_once('./autoload.php');

// Importação de classes
use src\controller\main\Main;
use src\controller\routers\RouterValidate;
use src\controller\routers\Router;
use src\model\Logs;

// Instâncimento de classes
$Main = new Main();
$RouterValidate = new RouterValidate();
$Logs = new Logs();
$result = null;

try {

    // Obtem as informações de requisição
    $request = Router::getInstance();

    // Obtenho as configurações da aplicação
    $MainGetConfigResult = $Main->GetConfig();

    // Parâmetros de entrada
    $RouterValidate->setPath($request->input('path'));

    // Verifico a existência de erros
    if (!empty($RouterValidate->getErrors())) {

        // Mensagem de erro
        throw new Exception($RouterValidate->getErrors());
    }

    // Processa a Rota solicitada
    $result = Router::process($RouterValidate, $request);

    // Define o delay de resposta
    sleep($MainGetConfigResult->delay);

    // Envio dos dados
    echo json_encode($result);

    // Encerra o procedimento
    exit;
} catch (Exception $exception) {

    // Pega os dados da exceção
    $result[] = Router::formatException($exception);

    // Define o delay de resposta
    sleep($MainGetConfigResult->delay);

    // Retorna em formato json
    echo json_encode($result);

    // Encerra a aplicação
    exit;
} catch (Error $error) {

    // Pega os dados do erro
    $result[] = Router::formatException($error);

    // Define o delay de resposta
    sleep($MainGetConfigResult->delay);

    // Retorna em formato json
    echo json_encode($result);

    // Encerra a aplicação
    exit;
}
