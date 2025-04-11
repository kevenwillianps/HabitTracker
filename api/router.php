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

    // RECEBER DADOS JSON
    $input = (object) json_decode(file_get_contents('php://input'), true);

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
    $RouterValidate->setPath(filter_var(@$input->path, FILTER_SANITIZE_SPECIAL_CHARS));

    // Verifico a existência de erros
    if (!empty($RouterValidate->getErrors())) {

        // Mensagem de erro
        throw new Exception($RouterValidate->getErrors());

    } else {

        // Verifico se o arquivo de ação existe
        if (is_file($RouterValidate->getFullPath())) {

            // Inicio a coleta de dados
            ob_start();

            // Inclusão do arquivo desejado
            @include_once $RouterValidate->getFullPath();

            // Prego a estrutura do arquivo
            $data = ob_get_contents();

            // Removo o arquivo incluido
            ob_end_clean();

            // Result
            $result = [

                'code' => 100,
                'data' => $data

            ];

        } else {

            // Mensagem de erro
            throw new Exception('Erro :: Não há arquivo para ação informada.');

        }

    }

    sleep($MainGetConfigResult->delay);

    // Envio dos dados
    echo json_encode($result);

    // Encerra o procedimento
    exit;

} catch (Exception $exception) {

    // Tratamento da mensagem de erro
    $resultException = '<b>Arquivo:</b> ' . $exception->getFile() . '; <b>Linha:</b> ' . $exception->getLine() . '; <b>Código:</b> ' . $exception->getCode() . '; <b>Mensagem:</b> ' . $exception->getMessage();

    // Verifico se devo realizar o log
    if (@(int) $UserSessionResult->user_id > 0) {

        // Escrevo a mensagem de requisição
        $_POST['exception'] = $resultException;

        // Defino os novos dados de log
        $LogsValidate->setLogTypeId(logTypeId: 2);
        $LogsValidate->setData(json_encode($_POST, JSON_PRETTY_PRINT));

        // Log de requisições
        $Logs->Save($LogsValidate->getLogId(), $LogsValidate->getLogTypeId(), $LogsValidate->getCompanyId(), $LogsValidate->getParentId(), $LogsValidate->getRegisterId(), $LogsValidate->getUserId(), $LogsValidate->getRequest(), $LogsValidate->getData(), $LogsValidate->getDateRegister());

    }

    // Preparo o formulário para o retorno
    $result = [

        'code' => 0,
        'modal' => [
            [
                'title' => 'Atenção',
                'data' => $resultException,
                'size' => 'md',
                'type' => null,
                'procedure' => null,
            ]
        ],

    ];

    // Envio dos dados
    echo json_encode($result);

    // Encerra o procedimento
    exit;

} catch (Error $error) {

    // Tratamento da mensagem de erro
    $resultError = '<b>Arquivo:</b> ' . $error->getFile() . '; <b>Linha:</b> ' . $error->getLine() . '; <b>Código:</b> ' . $error->getCode() . '; <b>Mensagem:</b> ' . $error->getMessage();

    // Verifico se devo realizar o log
    if (@(int) $UserSessionResult->user_id > 0) {

        // Escrevo a mensagem de requisição
        $_POST['error'] = $resultError;

        // Defino os novos dados de log
        $LogsValidate->setLogTypeId(logTypeId: 3);
        $LogsValidate->setData(json_encode($_POST, JSON_PRETTY_PRINT));

        // Log de requisições
        $Logs->Save($LogsValidate->getLogId(), $LogsValidate->getLogTypeId(), $LogsValidate->getCompanyId(), $LogsValidate->getParentId(), $LogsValidate->getRegisterId(), $LogsValidate->getUserId(), $LogsValidate->getRequest(), $LogsValidate->getData(), $LogsValidate->getDateRegister());

    }

    // Preparo o formulário para o retorno
    $result = [

        'code' => 0,
        'modal' => [
            [
                'title' => 'Atenção',
                'data' => $resultError,
                'size' => 'md',
                'type' => null,
                'procedure' => null,
            ]
        ],

    ];

    // Envio dos dados
    echo json_encode($result);

    // Encerra o procedimento
    exit;

}
