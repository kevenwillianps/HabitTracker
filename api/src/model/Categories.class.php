<?php

namespace src\model;

// Importação de Classe
use src\controller\categories\CategoriesValidate;

/**
* Classe responsável para manipular os dados da tabela de categories
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

class Categories extends CategoriesValidate {

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
		$this->sql = 'SELECT c.* FROM categories c';

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
	* @param CategoriesValidate $CategoriesValidate
	*
	* @return object|null
	*/
	public function get(CategoriesValidate $CategoriesValidate): object|false
	{

		// Consulta SQL
		$this->sql = 'SELECT * FROM categories c WHERE c.category_id = :categoryId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':categoryId', $CategoriesValidate->getCategoryId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}

	/**
	* Persitência de dados. Caso o ID seja zero sera criado um novo, caso não, o registro será atualizado
	*
	* @param CategoriesValidate $CategoriesValidate
	*
	* @return boolean|string
	*/
	public function save(CategoriesValidate $CategoriesValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'INSERT INTO categories(`category_id`, `name`)
						VALUES(:categoryId, :name);';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindValue(':categoryId', $CategoriesValidate->getCategoryId());
		$this->stmt->bindValue(':name', $CategoriesValidate->getName());

		// Executa o SQL
		return $this->stmt->execute();

	}

	/**
	* Remove um registro em específico
	*
	* @param CategoriesValidate $CategoriesValidate
	*
	* @return boolean|string
	*/
	public function delete(CategoriesValidate $CategoriesValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'DELETE FROM categories c WHERE c.category_id = :categoryId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindParam(':categoryId', $CategoriesValidate->getCategoryId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();

	}


}