<?php

/** Defino o local da classe */
namespace src\model;

// Importação de classes
use src\controller\main\Main;

/**
 * Classe responsável para manipular os dados
 * da tabela de Endereços de Logs
 * 
 * @category  Gestão de Intimação
 * @package   app\src\model
 * @author    Keven
 * @copyright 2025 CDL_DF
 * @license   MIT
 * @version   1.0.0
 * @link https://www.cdldf.souza.inf.br/
 */
class Logs
{

    /** Variaveis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $key = null;

    /**
	 * Contrutor da classe
	 */
    public function __construct()
    {

        /** Instanciamento da classe */
        $this->connection = new Mysql();

        // Busco a chave de criptografia dos dados
        $this->key = Main::GetKey();

    }

    /** Método para salvar um registro */
    public function Save(int $logId, int $logTypeId, int $companyId, ? int $parentId, ? int $registerId, int $userId, string $request, string $data, string $dateRegister)
    {

        /** Sql para inserção */
        $this->sql = 'INSERT INTO logs(`log_id`, `log_type_id`, `company_id`, `parent_id`, `register_id`, `user_id`, `request`, `data`, `date_register`) 
                      VALUES(:logId, :logTypeId, :companyId, :parentId, :registerId, :userId, :request, :data, :dateRegister)';

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os valores do sql */
        $this->stmt->bindParam(':logId', $logId, $logId > 0 ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
        $this->stmt->bindParam(':logTypeId', $logTypeId, $logTypeId > 0 ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
        $this->stmt->bindParam(':companyId', $companyId, $companyId > 0 ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
        $this->stmt->bindParam(':parentId', $parentId, $parentId > 0 ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
        $this->stmt->bindParam(':registerId', $registerId, $registerId > 0 ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
        $this->stmt->bindParam(':userId', $userId, $userId > 0 ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
        $this->stmt->bindParam(':request', $request);
        $this->stmt->bindParam(':data', $data);
        $this->stmt->bindParam(':dateRegister', $dateRegister);

        /** Execução do sql */
        return $this->stmt->execute();

    }

    public function AllByRegisterIdAndRequest(int $registerId, string $request)
    {

        // Consulta SQL
        $this->sql = 'SELECT l.*, u.* FROM logs l
                      JOIN users u on l.user_id = u.user_id
                      WHERE l.register_id = :registerId 
                      and l.request like :request
                      ORDER BY l.log_id DESC';

         // Preparo o SQL para execução
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        //Ajusto para pesquisa partes de palavras
        $request = '%' . $request . '%';

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':registerId', $registerId, \PDO::PARAM_STR);
        $this->stmt->bindParam(':request', $request, \PDO::PARAM_STR);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    public function AllByRequest(string $request)
    {

        // Consulta SQL
        $this->sql = 'SELECT l.*, u.* FROM logs l
                      JOIN users u on l.user_id = u.user_id
                      WHERE l.request like :request
                      ORDER BY l.log_id DESC
                      limit 10';

         // Preparo o SQL para execução
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        //Ajusto para pesquisa partes de palavras
        $request = '%' . $request . '%';

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':request', $request, \PDO::PARAM_STR);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    // public function AllByCompanyId(int $companyId)
    // {

    //     // Consulta SQL
    //     $this->sql = 'SELECT 
    //                     l.*, 
    //                     CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name
    //                   FROM logs l
    //                   JOIN users u on l.user_id = u.user_id
    //                   WHERE l.company_id = :companyId
    //                   ORDER BY l.log_id DESC 
    //                   LIMIT 100';

    //      // Preparo o SQL para execução
    //     $this->stmt = $this->connection->connect()->prepare($this->sql);

    //     // Preencho os parâmetros do SQL
    //     $this->stmt->bindParam(':companyId', $companyId, \PDO::PARAM_STR);
    //     $this->stmt->bindParam(':key', $this->key);

    //     // Executa o SQL
    //     $this->stmt->execute();

    //     // Retorna o resultado da consulta como um array de objetos.
    //     return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    // }

    public function AllByCompanyId(int $companyId)
    {

        // Consulta SQL
        $this->sql = 'SELECT 
                        l.*, 
                        CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name
                      FROM logs l
                      JOIN users u on l.user_id = u.user_id
                      WHERE l.company_id = :companyId
                      LIMIT 1000';

         // Preparo o SQL para execução
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':companyId', $companyId, \PDO::PARAM_STR);
        $this->stmt->bindParam(':key', $this->key);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    public function AllByUserId(int $userId)
    {

        // Consulta SQL
        $this->sql = 'SELECT 
                        l.*, 
                        CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name
                      FROM logs l
                      JOIN users u on l.user_id = u.user_id
                      WHERE l.user_id = :userId
                      LIMIT 1000';

         // Preparo o SQL para execução
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':userId', $userId, \PDO::PARAM_STR);
        $this->stmt->bindParam(':key', $this->key);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    public function GetFirstByTableByRegisterId(string $request, int $registerId)
    {

        // Consulta SQL
        $this->sql = 'SELECT l.*
                        FROM logs l
                        WHERE l.register_id = :registerId 
                          AND l.request LIKE :request
                        LIMIT 1;';

         // Preparo o SQL para execução
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        // Ajusto para pesquisa partes de palavras
        $request = '%' . $request . '%';

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':request', $request, \PDO::PARAM_STR);
        $this->stmt->bindParam(':registerId', $registerId, \PDO::PARAM_STR);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchObject();

    }

    public function GraphByCompanyId(int $companyId)
    {

        // Consulta SQL
        $this->sql = 'SELECT 
                            COUNT(l.log_id) AS quantity,
                            DATE_FORMAT(l.date_register, \'%d-%m-%Y\') AS date_register_formated
                        FROM 
                            logs l
                        WHERE l.company_id = :companyId
                        GROUP BY 
                            date_register_formated;';

         // Preparo o SQL para execução
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':companyId', $companyId, \PDO::PARAM_STR);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Destrutor da classe */
    public function __destruct()
    {

        /** Instanciamento da classe */
        $this->connection = null;

    }

}
