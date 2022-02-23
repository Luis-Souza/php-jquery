<?php

namespace App\Http\Repositories;

use App\Http\Models\User;

interface iUserRepository {
  public function save(User $user);
  public function update(User $user);
  public function delete(string $id);
  public function findByName(string $name);
  public function findByEmail(string $email);
  public function listAll();
}