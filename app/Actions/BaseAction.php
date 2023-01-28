<?php

namespace App\Actions;

interface BaseAction {
    public function create(array $data);
    public function findAll();
    public function findOne(int $id);
    public function update(int $id, array $data);
    public function remove(int $id);
}