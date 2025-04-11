<?php

// Defino o local onde esta a classe
namespace src\controller\routers;

// Importação de classes
use src\controller\main\Main;

/**
 * Classe responsável pelo gerenciamento de rotas que podem ou não ser acessadas sem autenticação
 *
 * @category  Gestão de Rotas
 * @package   app\src\controller\routers
 * @author    Keven
 * @copyright 2025 CDL_DF
 * @license   MIT
 * @version   1.0.0
 * @link https://www.cdldf.souza.inf.br/
 */
class RouterAuth
{

    // Parâmetros da classe
    private bool $status = false;

    /**
     * Defino e verifico quais arquivos podem ser acessados sem autenticação
     *
     * @param string $path
     *
     * @return boolean
     */
    public function checkAccess(string $path): bool
    {

        // Instânciamento da classe Principal
        $Main = new Main();

        // Obtenho as configurações da aplicação
        $MainGetConfigResult = $Main->GetConfig();

        // Defino os arquivos autorizados
        $result = [
            'view/users/users_register.php',
            'view/users/users_login.php',
            'view/users/users_login.php',
            'action/users/users_login.php',
            'action/users/users_authenticate.php',
            'view/users/users_request_new_password.php',
            'action/users/users_request_new_password.php',
            'action/users/users_register_new_password.php',
            'action/geral/geral_index.php',
        ];

        // Verifico se existe o valor na array
        if (!in_array($path, $result)) {

            // Obtenho os dados da sessão
            @$UserSessionResult = $_SESSION[$MainGetConfigResult->session->name];

            // Verifico se existe sessão ativa
            if (@(int) $UserSessionResult->user_id === 0) {

                // Informo que a sessão esta inativa
                $this->status = false;

            } else {

                // Informo que a sessão esta ativa
                $this->status = true;

            }

        } else {

            // Informo que a sessão esta ativa
            $this->status = true;

        }

        // Retorno da informação
        return $this->status;

    }

}
