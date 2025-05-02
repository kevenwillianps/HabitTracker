<?php

namespace src\controller\groups;

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
class GroupsValidate
{

	private int $groupId;
	private string $name;
	private string $preferences;
	private array $errors = [];

	/** 
	 * Validação da informação "groupId" 
	 * 
	 * @param int groupId 
	 * 
	 * @return void 
	 */
	public function setGroupId(int $groupId): void
	{
		$this->groupId = $groupId;
	}

	/** 
	 * Recuperação da informação "groupId" 
	 * 
	 * @return int 
	 */
	public function getGroupId(): int
	{
		return $this->groupId;
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
	 * Validação da informação "name" 
	 * 
	 * @param string name 
	 * 
	 * @return void 
	 */
	public function setPreferences(string $preferences): void
	{
		$this->preferences = $preferences;
	}

	/** 
	 * Recuperação da informação "name" 
	 * 
	 * @return string 
	 */
	public function getPreferences(): string
	{
		return $this->preferences;
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
