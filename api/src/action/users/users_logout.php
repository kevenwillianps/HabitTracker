<?php

// Inicia a sessão
session_start();

// Verifica se a sessão está ativa
if (isset($_SESSION[$MainGetConfigResult->session->name])) {

    // Limpa todas as variáveis de sessão
    session_unset();

    // Destroi a sessão
    session_destroy();

    // Opcional: Remove o cookie da sessão, se quiser garantir que ele foi excluído
    if (ini_get('session.use_cookies')) {

        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );

    }

    // Result
    $result = [

        'code' => 200,
        'toast' => [
            [
                'background' => 'primary',
                'data' => 'Sessão encerrada!'
            ]
        ],
        'reload' => [
            [
                'url' => $MainGetConfigResult->url_application,
            ]
        ],

    ];

} else {

    // Result
    $result = [

        'code' => 200,
        'toast' => [
            [
                'background' => 'primary',
                'data' => 'Sessão encerrada!'
            ]
        ],
        'reload' => [
            [
                'url' => $MainGetConfigResult->url_application,
            ]
        ],

    ];

}

// Envio dos dados
echo json_encode($result);

// Encerro o procedimento
exit;
