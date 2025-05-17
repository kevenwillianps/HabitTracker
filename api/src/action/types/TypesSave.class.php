<?php

namespace src\action\types;

// Importação de classes
use src\controller\routers\Router;
use src\model\Types;
use src\controller\types\TypesValidate;

class TypesSave
{

    public static function execute(Router $request)
    {

        // Verifica se os verbos são iguais
        Router::checkVerb('POST', $request->input('request_method'));

        // Instâncimento de classes
        $Types = new Types();
        $TypesValidate = new TypesValidate();

        // Controle de resultados
        $result = null;

        // Validação do campos de entrada
        $TypesValidate->setTypeId((int) $request->input('type_id'));
        $TypesValidate->setName($request->input('name'));
        $TypesValidate->setDescription($request->input('description'));

        // Verifico a existência de erros
        if (count($TypesValidate->getErrors()) > 0) {

            // Mensagem de erro
            throw new \Exception(json_encode($TypesValidate->getErrors()));
        } else {

            // Efetua um novo cadastro ou atualiza o existente
            if ($Types->save($TypesValidate)) {

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
