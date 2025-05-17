<?php

namespace src\action\habits;

// Importação de classes
use src\model\Habits;
use src\controller\habits\HabitsValidate;
use src\controller\routers\Router;

class HabitsDelete
{

    public static function execute(Router $request)
    {

        // Instâncimento de classes
        $Habits = new Habits();
        $HabitsValidate = new HabitsValidate();

        // Controle de resultados
        $result = null;

        // Validação do campos de entrada
        $HabitsValidate->setHabitId($request->input('habit_id'));

        // Verifico a existência de erros
        if (count($HabitsValidate->getErrors()) > 0) {

            // Mensagem de erro
            throw new \Exception(json_encode($HabitsValidate->getErrors()));
        } else {

            // Busca o registro desejado
            $HabitsGetResult = $Habits->get($HabitsValidate);

            // Verifico a existência do registro
            if ($HabitsGetResult->habit_id > 0) {

                // Efetua um novo cadastro ou atualiza o existente
                if ($Habits->delete($HabitsValidate)) {

                    // Result
                    $result = [

                        'code' => 200,
                        'data' => 'Registro removido com sucesso!',

                    ];
                } else {

                    // Retorno da mensagem de erro
                    throw new \InvalidArgumentException('Não foi possivel remover o registro', 0);
                }
            } else {

                // Retorno da mensagem de erro
                throw new \InvalidArgumentException('Não foi possivel remover o registro', 0);
            }
        }

        return $result;

    }
}
