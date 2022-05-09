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
        return self::getModel()::all();
    }

    /**
     * @param int $id
     * @return Role
     */
    public function getById(int $id): Role
    {
        return self::getModel()::find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exitsById(int $id): bool
    {
        return (bool)self::getModel()::find($id);
    }
}
