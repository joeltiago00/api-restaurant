<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Menu::class);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return (bool)self::getModel()::find($id);
    }

    /**
     * @return Collection
     */
    public function getAllWithItems(): Collection
    {
        return self::getModel()::with('items')->get();
    }
}
