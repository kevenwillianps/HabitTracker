<?php

namespace src\controller\habits;

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
class HabitsValidate
{

	private null|int $habitId = null;
	private null|int $situationId = null;
	private null|int $groupId = null;
	private null|int $categoryId = null;
	private null|int $typeId = null;
	private null|int $userId = null;
	private null|string $name = null;
	private null|string $description = null;
	private null|string $url = null;
	private null|string $startsIn = null;
	private null|string $endsIn = null;
	private array $errors = [];

	/** 
	 * Validação da informação "habitId" 
	 * 
	 * @param int habitId 
	 * 
	 * @return void 
	 */
	public function setHabitId(int $habitId): void
	{
		$this->habitId = $habitId;
	}

	/** 
	 * Recuperação da informação "habitId" 
	 * 
	 * @return int 
	 */
	public function getHabitId(): int
	{
		return $this->habitId;
	}

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
	 * Validação da informação "userId" 
	 * 
	 * @param int userId 
	 * 
	 * @return void 
	 */
	public function setUserId(int $userId): void
	{
		$this->userId = $userId;
	}

	/** 
	 * Recuperação da informação "userId" 
	 * 
	 * @return int 
	 */
	public function getUserId(): int
	{
		return $this->userId;
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
	 * Validação da informação "url" 
	 * 
	 * @param string url 
	 * 
	 * @return void 
	 */
	public function setUrl(string $url): void
	{
		$this->url = $url;
	}

	/** 
	 * Recuperação da informação "url" 
	 * 
	 * @return string 
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/** 
	 * Validação da informação "startsIn" 
	 * 
	 * @param string startsIn 
	 * 
	 * @return void 
	 */
	public function setStartsIn(string $startsIn): void
	{
		$this->startsIn = $startsIn;
	}

	/** 
	 * Recuperação da informação "startsIn" 
	 * 
	 * @return string 
	 */
	public function getStartsIn(): string
	{
		return $this->startsIn;
	}

	/** 
	 * Validação da informação "endsIn" 
	 * 
	 * @param string endsIn 
	 * 
	 * @return void 
	 */
	public function setEndsIn(string $endsIn): void
	{
		$this->endsIn = $endsIn;
	}

	/** 
	 * Recuperação da informação "endsIn" 
	 * 
	 * @return string 
	 */
	public function getEndsIn(): string
	{
		return $this->endsIn;
	}

	/** 
	 * Recuperação da informação "Errors" 
	 * 
	 * @return array 
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}
