<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository implements BaseRepository{
    
	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data)
    {
        return User::create($data);
	}
	
	/**
	 * @return mixed
	 */
	public function findAll() 
    {
        return User::all();
	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function findOne(int $id) 
    {
        return User::findOrFail($id);
	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function remove(int $id) 
    {
        return User::destroy($id);
	}
}