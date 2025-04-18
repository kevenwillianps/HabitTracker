<?php

// Defino o local onde esta a classe
namespace src\controller\routers;

// Importação de classes
use src\controller\main\Main;
use src\controller\routers\RouterValidate;

/**
 * Classe responsável para tratar os dados da Rota
 *
 * @category  Gestão de Intimação
 * @package   app\src\controller\routers
 * @author    Keven
 * @copyright 2025 CDL_DF
 * @license   MIT
 * @version   1.0.0
 * @link https://www.cdldf.souza.inf.br/
 */
class RouterHandling extends RouterValidate
{

    public static function formatException($data) : string {
        
        return 'Arquivo: ' . $data->getFile() . '; Linha: ' . $data->getLine() . '; Código: ' . $data->getCode() . '; Mensagem: ' . $data->getMessage();

    }

    public static function process(RouterValidate $RouterValidate) : string
    {

        // Inicio a coleta de dados
        ob_start();

        // Inclusão do arquivo desejado
        @include_once $RouterValidate->getFullPath();

        // Prego a estrutura do arquivo
        $data = ob_get_contents();

        // Removo o arquivo incluido
        ob_end_clean();

        // retorno da informação
        return $data;

    }

}
