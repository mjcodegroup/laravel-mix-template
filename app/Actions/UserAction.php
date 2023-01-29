<?php

namespace App\Actions;

use Exception;
use App\Dtos\ResponseDto;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

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
        //encrypt the user password
        $data['password'] = Hash::make($data['password']);
        $createdUser = $this->userRepository->create($data);
        if (!$createdUser) {
            throw new Exception("Failed to create user.", ResponseDto::INTERNAL_SERVER_ERROR);
        }
        return $createdUser;
	}
	
	/**
	 * @return mixed
	 */
	public function findAll() 
    {
        return $this->userRepository->findAll();
	}
	
	/**
	 *
	 * @param number $id
	 * @return mixed
	 */
	public function findOne(int $id) 
    {
        $foundUser = $this->userRepository->findOne($id);
        if (!$foundUser) {
            throw new Exception("User not found", ResponseDto::NOT_FOUND);
        }
        return $foundUser;
	}

    /**
	 * @param int $id
	 * @param array $data
	 * @return mixed
	 */
	public function update(int $id, array $data) 
    {
        $this->findOne($id);
        //don t let modify the user password from here
        if (isset($data['password'])) {
            unset($data['password']);
        }

        $response = $this->userRepository->update($id, $data);
        if (!$response) {
            throw new Exception("Failed to update user", ResponseDto::INTERNAL_SERVER_ERROR);
        }
        return $response;
	}
	
	/**
	 *
	 * @param number $id
	 * @return mixed
	 */
	public function remove(int $id) 
    {
        $this->findOne($id);
        $response = $this->userRepository->remove($id);
        if (!$response) {
            throw new Exception("Failed to delete user", ResponseDto::INTERNAL_SERVER_ERROR);
        }
        return $response;
	}
}