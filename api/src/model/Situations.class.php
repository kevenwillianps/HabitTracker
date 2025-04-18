<?php

namespace src\model;

// Importação de Classe
use src\controller\situations\SituationsValidate;

/**
* Classe responsável para manipular os dados da tabela de situations
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

class Situations extends SituationsValidate {

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
		$this->sql = 'SELECT s.* FROM situations s';

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
	* @param SituationsValidate $SituationsValidate
	*
	* @return object|null
	*/
	public function get(SituationsValidate $SituationsValidate): object|false
	{

		// Consulta SQL
		$this->sql = 'SELECT * FROM situations s WHERE s.situation_id = :situationId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':situationId', $SituationsValidate->getSituationId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}

	/**
	* Persitência de dados. Caso o ID seja zero sera criado um novo, caso não, o registro será atualizado
	*
	* @param SituationsValidate $SituationsValidate
	*
	* @return boolean|string
	*/
	public function save(SituationsValidate $SituationsValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'INSERT INTO situations(`situation_id`, `name`, `description`)
					  VALUES(:situationId, :name, :description);';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':situationId', $SituationsValidate->getSituationId());
		$this->stmt->bindParam(':name', $SituationsValidate->getName());
		$this->stmt->bindParam(':description', $SituationsValidate->getDescription());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}

	/**
	* Remove um registro em específico
	*
	* @param SituationsValidate $SituationsValidate
	*
	* @return boolean|string
	*/
	public function delete(SituationsValidate $SituationsValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'DELETE FROM situations s WHERE s.situation_id = :situationId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':situationId', $SituationsValidate->getSituationId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}


}