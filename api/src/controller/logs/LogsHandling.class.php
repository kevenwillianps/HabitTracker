<?php

// Defino o local onde esta a classe
namespace src\controller\logs;

/**
 * Classe responsável para manipular os dados do Log
 *
 * @category  Gestão de Intimação
 * @package   app\src\controller\logs
 * @author    Keven
 * @copyright 2025 CDL_DF
 * @license   MIT
 * @version   1.0.0
 * @link https://www.cdldf.souza.inf.br/
 */
class LogsHandling
{

    /**
     * Função responsável por retorna uma breve descrição
     * da rota de acordo com o nome da rota informada
     *
     * @param string $path
     *
     * @return void
     */
    public function dictionary(string $path)
    {

        $descriptions = [

            'view/intimacao/intimacao_dashboard.php' => 'Acessou o dashboard de intimações',
            'view/intimacao/intimacao_datagrid.php' => 'Acessou a listagem de intimações',
            'view/intimacao/intimacao_details.php' => 'Acessou os detalhes da intimação',
            'view/pagamentos/pagamentos_datagrid.php' => 'Acesso a listagem de arquivos da intimação',
            'view/pagamentos/pagamentos_details.php' => 'Acessou os detalhes do arquivo da intimação',
            'view/intimacao/intimacao_form.php' => 'Acessou o formulário da intimação',
            'view/intimacao/intimacao_index.php' => 'Acessou a página inicial de intimação',
            'view/intimacao/intimacao_messages_datagrid.php' => 'Acessou a listagem de mensagens da intimação',
            'view/intimacao/intimacao_messages_details.php' => 'Acessou os detalhes da mensagem da intimação',
            'view/intimacao/intimacao_messages_form.php' => 'Acessou o formulário de mensagens da intimação',
            'action/intimacao/intimacao_delete.php' => 'Removeu a intimação',
            'action/intimacao/intimacao_save_situation.php' => 'Alterou a situação da intimação',
            'action/intimacao/intimacao_save.php' => 'Cadastrou uma nova intimação',
            'action/intimacao/intimacao_xml.php' => 'Gerou o xml da intimação',

            'view/companies/companies_details.php' => 'Acessou os detalhes da empresa',
            'view/companies/companies_form.php' => 'Acessou o formulário da empresa',
            'view/companies/companies_index.php' => 'Acessou a listagem de empresas',
            'action/companies/companies_delete.php' => 'Removeu a empresa',
            'action/companies/companies_save.php' => 'Cadastrou uma nova empresa',
            
            'action/messages/messages_delete.php' => 'Removeu a mensagem',
            'action/messages/messages_save.php' => 'Cadastrou uma nova mensagem',

            'view/modules/modules_details.php' => 'Acessou os detalhes do módulo',
            'view/modules/modules_form.php' => 'Acessou o formulário do módulo',
            'view/modules/modules_index.php' => 'Acessou a listagem de módulos',
            'action/modules/modules_delete.php' => 'Removeu o módulo',
            'action/modules/modules_save.php' => 'Cadastrou um novo módulo',

            'view/modules_acls/modules_acls_details.php' => 'Acessou os detalhes do nível de acesso do módulo',
            'view/modules_acls/modules_acls_form.php' => 'Acessou o formulário do nível de acesso do módulo',
            'view/modules_acls/modules_acls_index.php' => 'Acessou a listagem de níveis de acesso do módulo',
            'action/modules_acls/modules_acls_delete.php' => 'Removeu o nível de acesso do módulo',
            'action/modules_acls/modules_acls_save.php' => 'Cadastrou um novo nível de acesso do módulo',

            'view/pagamentos/pagamentos_form.php' => 'Acessou o formulário do pagamentos',
            'action/pagamentos/pagamentos_delete.php' => 'Removeu o nível pagamento',
            'action/pagamentos/pagamentos_save.php' => 'Cadastrou um novo pagamento',

            'view/pessoas/pessoas_details.php' => 'Acessou os detalhes da pessoa',
            'view/pessoas/pessoas_form.php' => 'Acessou o formulário da pessoa',
            'view/pessoas/pessoas_index.php' => 'Acessou a listagem de pessoas',
            'action/pessoas/pessoas_delete.php' => 'Removeu a pessoa',
            'action/pessoas/pessoas_save.php' => 'Cadastrou uma nova pessoa',

            'view/users/users_autenticate.php' => 'Acessou os detalhes da empresa',
            'view/users/users_form.php' => 'Acessou o formulário da empresa',
            'view/users/users_index.php' => 'Acessou a listagem de empresas',
            'action/users/users_delete.php' => 'Removeu o usuário',
            'action/users/users_login.php' => 'Realizou Login',
            'action/users/users_logout.php' => 'Realizou Logout',
            'action/users/users_register_new_password.php' => 'Registrou uma nova senha',
            'action/users/users_request_new_password.php' => 'Requisitou uma nova senha',
            'action/users/users_save.php' => 'Cadastrou um novo usuário',

        ];

        // Verifico a descricao que devo retornar
        return $descriptions[$path];

    }

}
