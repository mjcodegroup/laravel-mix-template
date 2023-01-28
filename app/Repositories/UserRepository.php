<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository implements BaseRepository{
    
    private $user;
    public function __construct()
    {
        $this->user = new User();
    }
	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data)
    {
        return $this->user->create($data);
	}
	
	/**
	 * @return mixed
	 */
	public function findAll() 
    {
        return $this->user->all();
	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function findOne(int $id) 
    {
        return $this->user->find($id);
	}

    /**
	 * @param int $id
	 * @param array $data
	 * @return mixed
	 */
    public function update(int $id, array $data)
    {
        $this->user = $this->findOne($id);
        return $this->user->update($data);
	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function remove(int $id) 
    {
        $this->user = $this->findOne($id);
        return $this->user->destroy($id);
	}
}