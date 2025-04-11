<?php

// Defino o local onde esta a classe
namespace src\controller\logs;

// Importação de classes
use src\controller\main\Main;

/**
 * Classe responsável para tratar os dados do Log
 *
 * @category  Gestão de Intimação
 * @package   app\src\controller\logs
 * @author    Keven
 * @copyright 2025 CDL_DF
 * @license   MIT
 * @version   1.0.0
 * @link https://www.cdldf.souza.inf.br/
 */
class LogsValidate
{

    // Parâmetros da classe
    private Main $Main;
    private array $errors = [];


    private null|int $logId;
    private null|int $logTypeId;
    private null|int $companyId;
    private null|int $userId;
    private null|int $parentId;
    private null|int $registerId;
    private null|string $request;
    private null|string $data;
    private null|string $dateRegister;
    private null|string $status;

    /**
     * Contrutor da classe
     */
    public function __construct()
    {

        // Instâncimento de classes
        $this->Main = new Main();

    }

    public function setLogId(int $logId): void
    {

        // Trata a informação
        $this->logId = isset($logId) ? $this->Main->antiInjection($logId) : 0;

    }

    public function getLogId(): int
    {

        // Retorno da informação
        return (int)$this->logId;

    }

    public function setLogTypeId(int $logTypeId): void
    {

        // Trata a informação
        $this->logTypeId = isset($logTypeId) ? $this->Main->antiInjection($logTypeId) : 0;

    }

    public function getLogTypeId(): int
    {

        // Retorno da informação
        return (int)$this->logTypeId;

    }

    
    public function setCompanyId(int $companyId): void
    {

        // Trata a informação
        $this->companyId = isset($companyId) ? $this->Main->antiInjection($companyId) : 0;

    }

    public function getCompanyId(): int
    {

        // Retorno da informação
        return (int)$this->companyId;

    }

    public function setUserId(int $userId): void
    {

        // Trata a informação
        $this->userId = isset($userId) ? $this->Main->antiInjection($userId) : 0;

    }

    public function getUserId(): int
    {

        // Retorno da informação
        return (int)$this->userId;

    }

    public function setParentId(int $parentId): void
    {

        // Trata a informação
        $this->parentId = isset($parentId) ? $this->Main->antiInjection($parentId) : 0;

    }

    public function getParentId(): int
    {

        // Retorno da informação
        return (int)$this->parentId;

    }

    public function setRegisterId(int $registerId): void
    {

        // Trata a informação
        $this->registerId = isset($registerId) ? $this->Main->antiInjection($registerId) : 0;

    }

    public function getRegisterId(): int
    {

        // Retorno da informação
        return (int)$this->registerId;

    }

    public function setRequest(string $request): void
    {

        // Trata a informação
        $this->request = isset($request) ? $this->Main->antiInjection($request) : null;

    }

    public function getrequest(): string
    {

        // Retorno da informação
        return (string)$this->request;

    }

    public function setData(string $data): void
    {

        // Trata a informação
        $this->data = isset($data) ? $this->Main->antiInjection($data, 'S') : null;

    }

    public function getData(): string
    {

        // Retorno da informação
        return (string)$this->data;

    }

    public function setDateRegister(string $dateRegister): void
    {

        // Trata a informação
        $this->dateRegister = isset($dateRegister) ? $this->Main->antiInjection($dateRegister) : null;

    }

    public function getDateRegister(): string
    {

        // Retorno da informação
        return (string)$this->dateRegister;

    }

    public function checkException($path)
    {

        $result = [
            'action/files/files_save_chunk.php',
        ];

        /** Verifico se existeo valor na array */
        if (in_array($path, $result)) {

            /** Informo que a sessão esta ativa */
            $this->status = false;

        } else {

            /** Informo que a sessão esta ativa */
            $this->status = true;

        }

        // Retorno da informação
        return $this->status;

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
