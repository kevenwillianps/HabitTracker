<?php

// Defino o local onde esta a classe
namespace src\controller\routers;

// Importação de classes

use Exception;
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
class Router extends RouterValidate
{

    private static ?Router $instance = null;

    private array $get;
    private array $post;
    private array $server;
    private object $json;
    private $data;

    public function __construct()
    {
        // Obtem o campos enviados pelo GET
        $this->get = $_GET;
        // Obtem o campos enviados pelo POST
        $this->post = $_POST;
        // Obtem o campos enviados pelo SERVER
        $this->server = $_SERVER;
        // Decodifica o JSON
        $jsonDecoded = json_decode(file_get_contents('php://input'), true);
        // Verifica se o JSON foi decodificado corretamente
        $this->json = is_array($jsonDecoded) ? (object) $jsonDecoded : (object)[];

        // Unifica os dados em uma única fonte
        $this->data = array_merge(
            $this->get,
            $this->post,
            $this->server,
            (array) $this->json
        );

        // Converto todas as chaves da array para minusculo
        $this->data = (object) array_change_key_case($this->data, CASE_LOWER);

        // Chama a função de sanitização
        $this->sanitize();

    }

    public static function getInstance(): Router
    {

        // Verifica se a instância já foi criada
        if (self::$instance === null) {

            // Se não, cria uma nova instância
            self::$instance = new Router();
        }

        // Retorna a instância
        return self::$instance;
    }

    // Santiiza os dados de entrada
    private function sanitize()
    {

        // Percorre todos os dados
        foreach ($this->data as $key => $value) {

            // Limpa os dados
            $this->data->$key = Main::antiInjection($value);

        }

    }

    // Retorna um campo (busca em JSON, POST e GET)
    public function input(string $key)
    {
        // Reotrna a informação consulta
        return $this->data->$key ?? null;
    }

    // Retorna todos os dados
    public function all()
    {
        // Reotrna a informação consulta
        return $this->data;
    }
 
    public static function formatException($data): string
    {

        // Retorna a mensagem de erro formatada
        return 'Arquivo: ' . $data->getFile() . '; Linha: ' . $data->getLine() . '; Código: ' . $data->getCode() . '; Mensagem: ' . $data->getMessage();
    }

    public static function process(RouterValidate $RouterValidate, $request): array
    {

        // Verifica se o arquivo existe
        if(!is_file($RouterValidate->getFullPath()))
        {
            // Mensagem de erro
            throw new \Exception('Erro :: Não há arquivo para ação informada.');
        }

        // Inicio a coleta de dados
        ob_start();

        // Inclusão do arquivo desejado
        @include_once $RouterValidate->getFullPath();

        // Prego a estrutura do arquivo
        $data = ob_get_contents();

        // Removo o arquivo incluido
        ob_end_clean();

        // Estrutura os dados de resposta
        $response = [
            'code' => 100,
            'data' => $data
        ];

        // retorno da informação
        return $response;

    }

    public static function checkVerb(string $expected, string $received)
    {

        if($expected !== $received)
        {

            throw new \Exception('Erro :: Verbo diferente do esperado');

        }

    }
}
