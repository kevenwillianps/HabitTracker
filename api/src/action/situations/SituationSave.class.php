<?php

// Define o local da classe
namespace src\action\situations;

// Importação de classes
use src\controller\routers\Router;
use src\model\Situations;
use src\controller\Situations\SituationsValidate;

class SituationSave
{

    public static function execute(Router $request)
    {

        // Instâncimento de classes
        $Situations = new Situations();
        $SituationsValidate = new SituationsValidate();

        // Controle de resultados
        $result = null;

        // Validação do campos de entrada
        $SituationsValidate->setSituationId((int) $request->input('situation_id'));
        $SituationsValidate->setName($request->input('name'));
        $SituationsValidate->setDescription($request->input('description'));

        // Verifico a existência de erros
        if (count($SituationsValidate->getErrors()) > 0) {

            // Mensagem de erro
            throw new \Exception(json_encode($SituationsValidate->getErrors()));
        } else {

            // Efetua um novo cadastro ou atualiza o existente
            if ($Situations->save($SituationsValidate)) {

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
