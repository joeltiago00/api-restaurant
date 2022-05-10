<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Role::class);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Role::all();
    }

    /**
     * @param int $id
     * @return Role
     */
    public function getById(int $id): Role
    {
        return Role::find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exitsById(int $id): bool
    {
        return (bool)Role::find($id);
    }
}
