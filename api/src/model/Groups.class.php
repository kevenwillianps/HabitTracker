<?php

namespace src\model;

// Importação de Classe
use src\controller\GroupsValidate;

/**
* Classe responsável para manipular os dados da tabela de groups
*
* @category 
* @package src\model
* @author Keven
* @copyright 2025 Keven
* @license MIT
* @version 1.0.0
* @link 
*
*/

class Groups extends GroupsValidate {

	// Declara as variáveis da classe 
	private Mysql $mysql;
	private null|string $sql;
	private object $stmt;

	public function __construct()
	{

		// Cria o objeto de conexão com o banco de dados
		$this->mysql = new Mysql();

	}

	/**
	* Lista todos os registros existentes
	*
	* @return array
	*/
	public function all(): array|false
	{

		// Consulta SQL
		$this->sql = 'SELECT g.* FROM groups g';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

	}

	/**
	* Busca um registro especifico pelo ID informado
	*
	* @param GroupsValidate $GroupsValidate
	*
	* @return object|null
	*/
	public function get(GroupsValidate $GroupsValidate): object|false
	{

		// Consulta SQL
		$this->sql = 'SELECT * FROM groups g WHERE g.group_id = :groupId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':groupId', $GroupsValidate->getGroupId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}

	/**
	* Persitência de dados. Caso o ID seja zero sera criado um novo, caso não, o registro será atualizado
	*
	* @param GroupsValidate $GroupsValidate
	*
	* @return boolean|string
	*/
	public function save(GroupsValidate $GroupsValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'INSERT INTO groups(`group_id`, `name`)
						VALUES(:groupId, :name);';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':groupId', $GroupsValidate->getGroupId());
		$this->stmt->bindParam(':name', $GroupsValidate->getName());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}

	/**
	* Remove um registro em específico
	*
	* @param GroupsValidate $GroupsValidate
	*
	* @return boolean|string
	*/
	public function delete(GroupsValidate $GroupsValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'DELETE FROM groups g WHERE g.group_id = :groupId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':groupId', $GroupsValidate->getGroupId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}


}