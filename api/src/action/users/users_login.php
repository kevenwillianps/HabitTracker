<?php

// Importação de classes
use src\controller\mail\Mail;
use src\controller\main\Main;
use src\model\Arquivos;
use src\model\UsersAcls;
use src\model\Users;
use src\controller\users\UsersValidate;

// Instânciamento de classes
$Mail = new Mail();
$Main = new Main();
$Arquivos = new Arquivos();
$UsersAcls = new UsersAcls();
$Users = new Users();
$UsersValidate = new UsersValidate();

// Declaração de variaveis
$result = null;

// Validação do campos de entrada
$UsersValidate->setUserId(0);
$UsersValidate->setEmail((string) filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL), 'email');
$UsersValidate->setPassword((string) filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS), 'password');
$remember = (bool) filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica a existência de erros
if (!empty($UsersValidate->getErrors())) {

    // Result
    $result = [

        'code' => 0,
        'invalid_inputs' => $UsersValidate->getInvalidInputs(),

    ];
} else {

    // Busca as configurações do sistema
    $MainGetConfigResult = $Main->GetConfig();

    // Realiza uma busca pelo email informado
    $UsersGetByEmailResult = $Users->GetByEmail($UsersValidate->getEmail());

    // Verifica se o email existe no banco de dados
    if (!empty($UsersGetByEmailResult->email)) {

        // Verifica se as senhas são iguais
        if (password_verify($UsersValidate->getPassword(), $UsersGetByEmailResult->password)) {

            // Controle de preferencias
            $preferences = [];

            // Estruturo as permissões
            foreach ($UsersAcls->AllByUserId($UsersGetByEmailResult->user_id) as $key => $result) {

                // Decodifico as preferências
                $result->preferences = json_decode($result->preferences, true);

                // Percorro todas as preferências
                foreach ($result->preferences as $keyPreference => $resultPreference) {

                    // Inicializa o módulo como um objeto caso ainda não exista
                    if (!isset($preferences[$result->module_name])) {

                        $preferences[$result->module_name] = new stdClass();
                    }

                    // Guarda a permissão como um atributo do objeto
                    $preferences[$result->module_name]->$resultPreference = true;
                }
            }

            // Guardos as preferencias estruturadas
            $UsersGetByEmailResult->preferences = (object) $preferences;

            // Busco o ultimo arquivo vinculado
            $ArquivosGetLastResult = $Arquivos->GetLastByRegisterIdAndTable($UsersGetByEmailResult->user_id, 'users');

            // Define a foto de perfil
            $UsersGetByEmailResult->profile_photo = $ArquivosGetLastResult->caminho . '/crop/' . $ArquivosGetLastResult->nome;

            // Inicializa a sessão
            session_start();

            // Guarda os dados da sessão
            $_SESSION[$MainGetConfigResult->session->name] = $UsersGetByEmailResult;

            // Inicia a coleta de objetos
            ob_start();

            // Inclusão do layout desejado
            @include_once 'src/view/mail/mail_users_login_email.php';

            // Obtem o conteudo do arquivo
            $html = ob_get_contents();

            // Remove o arquivo adicionado
            ob_clean();

            // Realiza o envio do email
            //$Mail->Send($html, (object)$UsersGetByEmailResult, 'Login Realizado: ' . date('d/m/Y H:i:s'), $MainGetConfigResult->mail);

            /** Definições do cookie */
            $cookieOptions = [
                'expires' => time() + (86400 * 30), # Duração de dias/vida do cookie
                'path' => '/',
                'secure' => true,
                'samesite' => 'None'
            ];

            // Verifica se o usuário deseja ser lembrado
            if ($remember) {

                // Armazena os valores em cookies por 30 dias
                setcookie('UserEmail', $UsersValidate->getEmail(), $cookieOptions);
                setcookie('UserPassword', $UsersValidate->getPassword(), $cookieOptions);
                setcookie('UserRemember', $remember, $cookieOptions);
                
            } else {

                // Remove os cookies se "Lembrar de mim" não estiver marcado
                setcookie('UserEmail', '', time() - 3600, "/");
                setcookie('UserPassword', '', time() - 3600, "/");
            }

            // Result
            $result = [

                'code' => 200,
                'toast' => [
                    [
                        'background' => 'primary',
                        'data' => 'Usuário localizado!'
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

                'code' => 0,
                'data' => 'Senha inválida',

            ];
        }
    } else {

        // Result
        $result = [

            'code' => 0,
            'data' => 'Não foi localizado usuário para o email informado',

        ];
    }
}

// Envio o resultado para a tela
echo json_encode($result);

// Encerro o procedimento
exit;
