<?php

namespace src\model;

// Importação de Classe
use src\controller\habits\HabitsValidate;

/**
* Classe responsável para manipular os dados da tabela de habits
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

class Habits extends HabitsValidate {

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
		$this->sql = 'SELECT h.* FROM habits h';

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
	* @param HabitsValidate $HabitsValidate
	*
	* @return object|null
	*/
	public function get(HabitsValidate $HabitsValidate): object|false
	{

		// Consulta SQL
		$this->sql = 'SELECT * FROM habits h WHERE h.habit_id = :habitId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':habitId', $HabitsValidate->getHabitId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}

	/**
	* Persitência de dados. Caso o ID seja zero sera criado um novo, caso não, o registro será atualizado
	*
	* @param HabitsValidate $HabitsValidate
	*
	* @return boolean|string
	*/
	public function save(HabitsValidate $HabitsValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'INSERT INTO habits(`habit_id`, `situation_id`, `group_id`, `category_id`, `type_id`, `user_id`, `name`, `description`, `url`, `starts_in`, `ends_in`)
					  VALUES(:habitId, :situationId, :groupId, :categoryId, :typeId, :userId, :name, :description, :url, :startsIn, :endsIn);';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':habitId', $HabitsValidate->getHabitId());
		$this->stmt->bindParam(':situationId', $HabitsValidate->getSituationId());
		$this->stmt->bindParam(':groupId', $HabitsValidate->getGroupId());
		$this->stmt->bindParam(':categoryId', $HabitsValidate->getCategoryId());
		$this->stmt->bindParam(':typeId', $HabitsValidate->getTypeId());
		$this->stmt->bindParam(':userId', $HabitsValidate->getUserId());
		$this->stmt->bindParam(':name', $HabitsValidate->getName());
		$this->stmt->bindParam(':description', $HabitsValidate->getDescription());
		$this->stmt->bindParam(':url', $HabitsValidate->getUrl());
		$this->stmt->bindParam(':startsIn', $HabitsValidate->getStartsIn());
		$this->stmt->bindParam(':endsIn', $HabitsValidate->getEndsIn());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}

	/**
	* Remove um registro em específico
	*
	* @param HabitsValidate $HabitsValidate
	*
	* @return boolean|string
	*/
	public function delete(HabitsValidate $HabitsValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'DELETE FROM habits h WHERE h.habit_id = :habitId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':habitId', $HabitsValidate->getHabitId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}


}