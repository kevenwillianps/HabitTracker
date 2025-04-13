<?php

// Defino o local onde esta a classe
namespace src\model;

// Importação de classes
use src\controller\main\Main;
use src\controller\users\UsersValidate;

/**
 * Classe responsável para manipular os dados
 * da tabela de de Usuários
 * 
 * @category  Gestão de Intimação
 * @package   app\src\model
 * @author    Keven
 * @copyright 2025 CDL_DF
 * @license   MIT
 * @version   1.0.0
 * @link https://www.cdldf.souza.inf.br/
 */
class Users extends UsersValidate
{
    // Declaro as variáveis da classe 
    private $MySql;
    private string $sql;
    private object $stmt;
    private null|string $key;

    /**
	 * Contrutor da classe
	 */
    public function __construct()
    {
        // Cria o objeto de conexão com o banco de dados
        $this->MySql = new Mysql();

        // Busco a chave de criptografia dos dados
        $this->key = Main::GetKey();

    }

    /** Localiza um usuário pelo e-mail e senha */
    public function Login(string $email, string $password) : object
    {

        // Parâmetros de entrada
        $this->email = $email;
        $this->password = $password;

        // Consulta SQL
        $this->sql = 'select u.user_id,
                             u.name
					  from users u
					  where u.email = :email
					        and u.password = :password;';

        // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':email', $this->email);
        $this->stmt->bindParam(':password', $this->password);

        // Executa o SQL
        $this->stmt->execute();

        // Retorno do resultado
        return $this->stmt->fetchObject();

    }

    /**
     * Persiste os dados no banco de dados.
     * Utilizando o COALESCE(NULLIF(:password, \'\'), `password`) irá manter a mesma senha
     * caso não tenha sido informada nenhuma senha nova
     *
     * @param UsersValidate $UsersValidate
     *
     * @return boolean|string
     */
    public function Save(UsersValidate $UsersValidate) : bool|string
    {

        // Consulta SQL
        $this->sql = 'INSERT INTO users (`user_id`, 
                                         `name`,
                                         `email`, 
                                         `password`) values (:userId, 
                                                            AES_ENCRYPT(:name, :key),
                                                            AES_ENCRYPT(:email, :key),
                                                            :password)
                      ON DUPLICATE KEY UPDATE `name` = AES_ENCRYPT(:name, :key), 
                                              `email` = AES_ENCRYPT(:email, :key), 
                                              `password` = COALESCE(NULLIF(:password, \'\'), `password`);';

        // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':userId', $UsersValidate->getUserId());
        $this->stmt->bindParam(':name', $UsersValidate->getName());
        $this->stmt->bindParam(':email', $UsersValidate->getEmail());
        $this->stmt->bindParam(':password', $UsersValidate->getPassword());
        $this->stmt->bindParam(':key', $this->key);

        // Executa o SQL
        return $this->stmt->execute();

    }

    /**
     * Atualiza o token para. Token que é utilizado para atualizar a senha do usuário
     *
     * @param integer $userId
     * @param string|null $token
     *
     * @return boolean|string
     */
    public function SaveToken(int $userId, ? string $token) : bool|string
    {

        // Consulta SQL
        $this->sql = 'UPDATE users set token = :token where user_id = :userId;';

        // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':userId', $userId);
        $this->stmt->bindParam(':token', $token, empty($token) ? \PDO::PARAM_NULL : \PDO::PARAM_STR);

        // Executa o SQL
        return $this->stmt->execute();

    }

    /**
     * Quando atualizado a senha é removido o token
     *
     * @param integer $userId
     *
     * @return boolean|string
     */
    public function RemoveToken(int $userId) : bool|string
    {

        // Consulta SQL
        $this->sql = 'UPDATE users set token = null where user_id = :userId;';

        // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':userId', $userId);

        // Executa o SQL
        return $this->stmt->execute();

    }

    /**
     * Atualiza apenas a senha do usuário
     *
     * @param integer $userId
     * @param string|null $password
     *
     * @return boolean|string
     */
    public function SavePassword(int $userId, ? string $password) : bool|string
    {

        // Consulta SQL
        $this->sql = 'UPDATE users set `password` = :password where user_id = :userId;';

        // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':userId', $userId);
        $this->stmt->bindParam(':password', $password);

        // Executa o SQL
        return $this->stmt->execute();

    }

    /**
     * Busca todos os registros existentes
     *
     * @return array|false
     */
    public function All() : array|false
    {

        // Consulta SQL
        $this->sql = 'SELECT
                         u.user_id,
                         CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name,
                         CAST(AES_DECRYPT(u.email, :key) AS CHAR) AS email
                      FROM users u';

         // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preenchimento de parâmetros
        $this->stmt->bindParam(':key', $this->key);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Busca todos os registros existentes por empresa
     *
     * @param integer $companyId
     *
     * @return array|false
     */
    public function AllByCompanyId(int $companyId) : array|false
    {

        // Consulta SQL
        $this->sql = 'SELECT
                        u.user_id,
                        u.company_id,
                        CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name,
                        CAST(AES_DECRYPT(u.email, :key) AS CHAR) AS email,
                        CAST(AES_DECRYPT(u.password, :key) AS CHAR) AS password,
                        CAST(AES_DECRYPT(u.position, :key) AS CHAR) AS position,
                        CAST(AES_DECRYPT(u.team, :key) AS CHAR) AS team,
                        u.token
                     FROM users u
                     WHERE u.company_id = :companyId';

         // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':companyId', $companyId);
        $this->stmt->bindParam(':key', $this->key);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Busca um registro em especifico
     *
     * @param integer $userId
     *
     * @return object|boolean
     */
    public function Get(int $userId) : object|bool
    {

        // Consulta SQL
        $this->sql = 'SELECT
                        u.user_id,
                        u.company_id,
                        CAST(AES_DECRYPT(c.name, :key) AS CHAR) AS company_name,
                        CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name,
                        CAST(AES_DECRYPT(u.email, :key) AS CHAR) AS email,
                        CAST(AES_DECRYPT(u.password, :key) AS CHAR) AS password,
                        CAST(AES_DECRYPT(u.position, :key) AS CHAR) AS position,
                        CAST(AES_DECRYPT(u.team, :key) AS CHAR) AS team,
                        u.token
                     FROM users u
                     JOIN companies c on u.company_id = c.company_id
                     WHERE u.user_id = :userId';

         // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':userId', $userId);
        $this->stmt->bindParam(':key', $this->key);

        // Executa o SQL
        $this->stmt->execute();

        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchObject();

    }

    /**
     * Busca o registro de acordo com o email informado
     *
     * @param string $email
     *
     * @return object|boolean
     */
    public function GetByEmail(string $email) : object|bool
    {
 
        // Consulta SQL
        $this->sql = 'SELECT
                        u.user_id,
                        u.company_id,
                        CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name,
                        CAST(AES_DECRYPT(u.email, :key) AS CHAR) AS email,
                        u.password,
                        CAST(AES_DECRYPT(u.position, :key) AS CHAR) AS position,
                        CAST(AES_DECRYPT(u.team, :key) AS CHAR) AS team,
                        u.token
                    FROM users u
                    WHERE u.email = AES_ENCRYPT(:email, :key)
                    ORDER BY u.user_id DESC
                    LIMIT 1;';
 
         // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);
 
        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':email', $email);
        $this->stmt->bindParam(':key', $this->key);
 
        // Executa o SQL
        $this->stmt->execute();
 
        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchObject();
 
    }

    /**
     * Localiza o usuário pelo token informado
     *
     * @param string $token
     *
     * @return object|boolean
     */
    public function GetByToken(string $token) : object|bool
    {
 
        // Consulta SQL
        $this->sql = 'SELECT
                        u.user_id,
                        u.company_id,
                        CAST(AES_DECRYPT(u.name, :key) AS CHAR) AS name,
                        CAST(AES_DECRYPT(u.email, :key) AS CHAR) AS email,
                        CAST(AES_DECRYPT(u.password, :key) AS CHAR) AS password,
                        CAST(AES_DECRYPT(u.position, :key) AS CHAR) AS position,
                        CAST(AES_DECRYPT(u.team, :key) AS CHAR) AS team,
                        u.token
                     FROM users u
                     WHERE u.token = :token 
                     order by user_id 
                     desc limit 1';
 
         // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);
 
        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':token', $token);
 
        // Executa o SQL
        $this->stmt->execute();
 
        // Retorna o resultado da consulta como um array de objetos.
        return $this->stmt->fetchObject();
 
    }

   /**
    * Remove um registro em específico
    *
    * @param integer $userId
    *
    * @return object|boolean
    */
    public function Delete(int $userId) : object|bool
    {

        // Consulta SQL
        $this->sql = 'DELETE FROM users WHERE user_id = :userId';

         // Preparo o SQL para execução
        $this->stmt = $this->MySql->connect()->prepare($this->sql);

        // Preencho os parâmetros do SQL
        $this->stmt->bindParam(':userId', $userId);

        // Executa o SQL
        return $this->stmt->execute();
        
    }
    
    /**
    * Encerra conexões abertas
    */
    public function __destruct()
    {

        $this->MySql = null;

    }

}
