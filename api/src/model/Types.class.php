<?php

namespace src\model;

// Importação de Classe
use src\controller\types\TypesValidate;

/**
 * Classe responsável para manipular os dados da tabela de types
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

class Types extends TypesValidate
{

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
	public static function all(): array|false
	{

		// Cria o objeto de conexão com o banco de dados
		$mysql = new Mysql();

		// Consulta SQL
		$sql = 'SELECT t.* FROM types t';

		// Preparo o SQL para execução
		$stmt = $mysql->connect()->prepare($sql);

		// Executa o SQL
		$stmt->execute();

		// Retorno do resultado
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	/**
	 * Busca um registro especifico pelo ID informado
	 *
	 * @param TypesValidate $TypesValidate
	 *
	 * @return object|null
	 */
	public function get(TypesValidate $TypesValidate): object|false
	{

		// Consulta SQL
		$this->sql = 'SELECT * FROM types t WHERE t.type_id = :typeId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindValue(':typeId', $TypesValidate->getTypeId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();
	}

	/**
	 * Persitência de dados. Caso o ID seja zero sera criado um novo, caso não, o registro será atualizado
	 *
	 * @param TypesValidate $TypesValidate
	 *
	 * @return boolean|string
	 */
	public function save(TypesValidate $TypesValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'INSERT INTO types(`type_id`, `name`, `description`)
						VALUES(:typeId, :name, :description);';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindValue(':typeId', $TypesValidate->getTypeId());
		$this->stmt->bindValue(':name', $TypesValidate->getName());
		$this->stmt->bindValue(':description', $TypesValidate->getDescription());

		// Executa o SQL
		return $this->stmt->execute();
	}

	/**
	 * Remove um registro em específico
	 *
	 * @param TypesValidate $TypesValidate
	 *
	 * @return boolean|string
	 */
	public function delete(TypesValidate $TypesValidate): bool|string
	{

		// Consulta SQL
		$this->sql = 'DELETE FROM types t WHERE t.type_id = :typeId';

		// Preparo o SQL para execução
		$this->stmt = $this->mysql->connect()->prepare($this->sql);

		// Preencho os parâmetros do SQL
		$this->stmt->bindValue(':typeId', $TypesValidate->getTypeId());

		// Executa o SQL
		$this->stmt->execute();

		// Retorno do resultado
		return $this->stmt->fetchObject();
	}
}
