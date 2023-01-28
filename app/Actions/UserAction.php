<?php

namespace App\Actions;

use App\Repositories\UserRepository;
use PHPUnit\TextUI\CliArguments\Exception;

class UserAction implements BaseAction
{
    private $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data)
    {
        $createdUser = $this->userRepository->create($data);
        if (!$createdUser) {
            throw new Exception("Failed to create user.");
        }
        return $createdUser;
	}
	
	/**
	 * @return mixed
	 */
	public function findAll() {
	}
	
	/**
	 *
	 * @param number $id
	 * @return mixed
	 */
	public function findOne(int $id) {
	}
	
	/**
	 *
	 * @param number $id
	 * @return mixed
	 */
	public function remove(int $id) {
	}
}