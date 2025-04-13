<?php

namespace src\controller\users;

/**
* Classe responsável para manipular os dados da tabela de users
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
class UsersValidate {

	private int $userId;
	private string $name;
	private string $email;
	private string $password;
	private string $token;
	private array $errors = [];

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
	 * Validação da informação "email" 
	 * 
	 * @param string email 
	 * 
	 * @return void 
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/** 
	 * Recuperação da informação "email" 
	 * 
	 * @return string 
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/** 
	 * Validação da informação "password" 
	 * 
	 * @param string password 
	 * 
	 * @return void 
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/** 
	 * Recuperação da informação "password" 
	 * 
	 * @return string 
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/** 
	 * Validação da informação "token" 
	 * 
	 * @param string token 
	 * 
	 * @return void 
	 */
	public function setToken(string $token): void
	{
		$this->token = $token;
	}

	/** 
	 * Recuperação da informação "token" 
	 * 
	 * @return string 
	 */
	public function getToken(): string
	{
		return $this->token;
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