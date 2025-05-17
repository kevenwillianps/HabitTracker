<?php

// Defino o local onde esta a classe
namespace src\controller\routers;

// Importação de classes
use src\controller\main\Main;

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
class RouterValidate
{

    // Parâmetros da classe
    private null|object $Main = null;
    private null|array $errors = array();
    private null|array $path = null;

    /**
     * Contrutor da classe
     */
    public function __construct()
    {

        // Instâncimento de classes
        $this->Main = new Main();
    }

    /**
     * Tratamento da informação "Caminho do Arquivo Solicitado"
     *
     * @param string $path
     *
     * @return void
     */
    public function setPath(string $path): void
    {

        // Trata a informação
        $this->path = explode('/', $path);
    }

    /**
     * Recuperação da informação "Caminho do Arquivo Solicitado"
     *
     * @return string
     */
    public function getPath(): string
    {

        // Retorno da informação
        return (string)$this->path;
    }

    /**
     * Recuperação do caminho absoluto do arquivo solicitado
     *
     * @return string
     */
    public function getFullPath(): string
    {

        // Retorno da informação
        return 'src\\' . $this->path[0] . '\\' . $this->path[1] . '\\' . str_replace('.php', '', $this->path[2]);
    }

    /**
     * Recuperação da Informação "Errors"
     *
     * @return string
     */
    public function getErrors(): string
    {

        // Formata os erros para uma lista
        return Main::HandlingErrors($this->errors);
    }
}
