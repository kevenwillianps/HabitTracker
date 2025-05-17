<?php

namespace src\action\habits;

// Importação de classes
use src\model\Habits;
use src\controller\habits\HabitsValidate;
use src\controller\routers\Router;

class HabitsSaveReadyOrNot
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

            // Busca o registro
            $HabitsGetResult = $Habits->get($HabitsValidate);

            if ($HabitsGetResult->situation_id == 1) {

                // Efetua um novo cadastro ou atualiza o existente
                if ($Habits->deleteSituation($HabitsValidate)) {

                    // Result
                    $result = [

                        'code' => 200,
                        'data' => 'Registro salvo com sucesso!',

                    ];
                } else {

                    // Retorno da mensagem de erro
                    throw new \InvalidArgumentException('Não foi possivel salvar o registro', 0);
                }
            } else {

                // Define como concluído
                $HabitsValidate->setSituationId(1);

                // Efetua um novo cadastro ou atualiza o existente
                if ($Habits->saveSituation($HabitsValidate)) {

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
        }

        return $result;
    }
}
