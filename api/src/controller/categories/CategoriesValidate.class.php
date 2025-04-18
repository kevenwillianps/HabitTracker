<?php

namespace src\controller\categories;

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
class CategoriesValidate {

	private int $categoryId;
	private string $name;
	private array $errors = [];

	/** 
	 * Validação da informação "categoryId" 
	 * 
	 * @param int categoryId 
	 * 
	 * @return void 
	 */
	public function setCategoryId(int $categoryId): void
	{
		$this->categoryId = $categoryId;
	}

	/** 
	 * Recuperação da informação "categoryId" 
	 * 
	 * @return int 
	 */
	public function getCategoryId(): int
	{
		return $this->categoryId;
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
	 * Recuperação da informação "errors" 
	 * 
	 * @return array 
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

}