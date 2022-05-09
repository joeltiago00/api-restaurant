<?php

namespace App\Repositories;

use App\Core\Interfaces\MenuInterface;
use App\Exceptions\Menu\MenuNotDeleted;
use App\Exceptions\Menu\MenuNotStored;
use App\Exceptions\Menu\MenuNotUpdated;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Menu::class);
    }

    /**
     * @param MenuInterface $menu
     * @return Menu
     * @throws MenuNotStored
     */
    public function store(MenuInterface $menu): Menu
    {
        try {
            return self::getModel()::create([
                'name' => $menu->getName()
            ]);
        } catch (\Exception $e) {
            throw new MenuNotStored($e);
        }
    }

    /**
     * @param Menu $menu
     * @param string $name
     * @return bool
     * @throws MenuNotUpdated
     */
    public function update(Menu $menu, string $name): bool
    {
        try {
            return $menu->update([
                'name' => $name
            ]);
        } catch (\Exception $e) {
            throw new MenuNotUpdated($e);
        }
    }

    /**
     * @param Menu $menu
     * @return bool
     * @throws MenuNotDeleted
     */
    public function delete(Menu $menu): bool
    {
        try {
            return (bool)$menu->delete();
        } catch (\Exception $e) {
            throw new MenuNotDeleted($e);
        }
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

    /**
     * @param int $pp
     * @return mixed
     */
    public function getAll(int $pp)
    {
        return self::getModel()::paginate($pp);
    }
}
