<?php

namespace src\controller\types;

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
class TypesValidate {

	private int $typeId;
	private string $name;
	private string $description;
	private array $errors = [];

	/** 
	 * Validação da informação "typeId" 
	 * 
	 * @param int typeId 
	 * 
	 * @return void 
	 */
	public function setTypeId(int $typeId): void
	{
		$this->typeId = $typeId;
	}

	/** 
	 * Recuperação da informação "typeId" 
	 * 
	 * @return int 
	 */
	public function getTypeId(): int
	{
		return $this->typeId;
	}

	/** 
	 * Validação da informação "name" 
	 * 
	 * @param string name 
	 * 
	 * @return void 
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/** 
	 * Recuperação da informação "name" 
	 * 
	 * @return string 
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/** 
	 * Validação da informação "description" 
	 * 
	 * @param string description 
	 * 
	 * @return void 
	 */
	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	/** 
	 * Recuperação da informação "description" 
	 * 
	 * @return string 
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/** 
	 * Recuperação da informação "errors" 
	 * 
	 * @return array 
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

}