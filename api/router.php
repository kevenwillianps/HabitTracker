<?php

global $UserSessionResult;

// Cabeçalhos de segurança
// header('X-Content-Type-Options: nosniff');
// header('X-Frame-Options: DENY');
// header('X-XSS-Protection: 1; mode=block');
// header('Content-Security-Policy: default-src \'self\';');

// Libera acesso de qualquer origem (útil em desenvolvimento)
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");

// // Para requisições OPTIONS (pré-flight)
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }

// Exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicializo a sessão
session_start();

// Importação do Autoload lado servidor
require_once('./autoload.php');

// Importação de classes
use src\controller\main\Main;
use src\controller\routers\RouterValidate;
use src\controller\routers\Router;
use src\controller\routers\RouterAuth;
use src\controller\logs\LogsValidate;
use src\model\Logs;

// Instâncimento de classes
$Main = new Main();
$RouterValidate = new RouterValidate();
$RouterAuth = new RouterAuth();
$LogsValidate = new LogsValidate();
$Logs = new Logs();
$result = null;

try {

    // Recebe dados json
    $request = (object) json_decode(file_get_contents('php://input'), true);

    // Obtem as informações de requisição
    $request2 = Router::getInstance();

    // Obtenho as configurações da aplicação
    $MainGetConfigResult = $Main->GetConfig();
 
    // Obtenho os dados do usuário
    @$UserSessionResult = $_SESSION[$MainGetConfigResult->session->name];

    //Converto todas as chaves da array para minusculo
    $_POST = array_change_key_case($_POST, CASE_LOWER);

    //Dados do ‘log’
    $LogsValidate->setLogId(0);
    $LogsValidate->setUserId((int) @$UserSessionResult->user_id);
    $LogsValidate->setCompanyId((int) @$UserSessionResult->company_id);
    $LogsValidate->setParentId((int) filter_input(INPUT_POST, 'log_parent_id', FILTER_SANITIZE_SPECIAL_CHARS));
    $LogsValidate->setRegisterId((int) filter_input(INPUT_POST, 'log_register_id', FILTER_SANITIZE_SPECIAL_CHARS));
    $LogsValidate->setRequest(@(string)filter_input(INPUT_POST, 'path', FILTER_SANITIZE_SPECIAL_CHARS));
    $LogsValidate->setDateRegister(date('Y/m/d H:i:s'));

    // Parâmetros de entrada
    $RouterValidate->setPath(filter_var(@$request->path, FILTER_SANITIZE_SPECIAL_CHARS));

    // Verifico a existência de erros
    if (!empty($RouterValidate->getErrors())) {

        // Mensagem de erro
        throw new Exception($RouterValidate->getErrors());
    } else {

        // Verifico se o arquivo de ação existe
        if (is_file($RouterValidate->getFullPath())) {

            // Result
            $result = [

                'code' => 100,
                'data' => Router::process($RouterValidate, $request)

            ];
        } else {

            // Mensagem de erro
            throw new Exception('Erro :: Não há arquivo para ação informada.');
        }
    }

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
