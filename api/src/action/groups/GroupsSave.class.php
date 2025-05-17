<?php

// Define o local da classe
namespace src\action\groups;

// Importação de classes
use src\model\Groups;
use src\controller\groups\GroupsValidate;
use src\controller\routers\Router;

class GroupsSave
{

    public static function execute(Router $request)
    {

        // Instâncimento de classes
        $Groups = new Groups();
        $GroupsValidate = new GroupsValidate();

        // Controle de resultados
        $result = null;

        // Validação do campos de entrada
        $GroupsValidate->setGroupId((int) $request->input('group_id'));
        $GroupsValidate->setName($request->input('name'));
        $GroupsValidate->setPreferences($request->input('preferences'));

        // Verifico a existência de erros
        if (count($GroupsValidate->getErrors()) > 0) {

            // Mensagem de erro
            throw new \Exception(json_encode($GroupsValidate->getErrors()));
        } else {

            // Efetua um novo cadastro ou atualiza o existente
            if ($Groups->save($GroupsValidate)) {

                // Result
                $result = [

                    'code' => 200,
                    'data' => 'Registro salvo com sucesso!',

                ];
            } else {

                // Retorno da mensagem de erro
                throw new \InvalidArgumentException('Não foi possivel salvar o registro', 0);
            }
        }

        return $result;
    }
}
