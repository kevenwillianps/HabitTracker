<?php

namespace src\controller\situations;

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
class SituationsValidate {

	private int $situationId;
	private string $name;
	private string $description;
	private array $errors = [];

	/** 
	 * Validação da informação "situationId" 
	 * 
	 * @param int situationId 
	 * 
	 * @return void 
	 */
	public function setSituationId(int $situationId): void
	{
		$this->situationId = $situationId;
	}

	/** 
	 * Recuperação da informação "situationId" 
	 * 
	 * @return int 
	 */
	public function getSituationId(): int
	{
		return $this->situationId;
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
	 * Recuperação de erros
	 * 
	 * @return array 
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

}