<?php

namespace App\Repositories;

use App\Core\Interfaces\MenuItemInterface;
use App\Exceptions\General\NothingToUpdate;
use App\Exceptions\Menu\{
    MenuItemNotDeleted,
    MenuItemNotStored,
    MenuItemNotUpdated,
    MenuNotFound
};
use App\Models\MenuItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MenuItemRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(MenuItem::class);
    }

    /**
     * @param MenuItemInterface $menuItem
     * @return MenuItem
     * @throws MenuItemNotStored
     * @throws MenuNotFound
     */
    public function store(MenuItemInterface $menuItem): MenuItem
    {
        if (!(new MenuRepository())->existsById($menuItem->getMenuId()))
            throw new MenuNotFound();

        try {
            return MenuItem::create([
                'menu_id' => $menuItem->getMenuId(),
                'name' => $menuItem->getName(),
                'price' => $menuItem->getPrice()
            ]);
        } catch (\Exception $e) {
            throw new MenuItemNotStored($e);
        }
    }

    /**
     * @param MenuItem $menuItem
     * @param array $data
     * @return bool
     * @throws MenuItemNotUpdated
     * @throws MenuNotFound
     * @throws NothingToUpdate
     */
    public function update(MenuItem $menuItem, array $data): bool
    {
        if (empty($data))
            throw new NothingToUpdate();

        if (isset($data['menu_id']) && ! (new MenuRepository())->existsById($data['menu_id']))
            throw new MenuNotFound();

        try {
            return $menuItem->update([
                'menu_id' => $data['menu_id'] ?? $menuItem->menu_id,
                'name' => $data['name'] ?? $menuItem->name,
                'price' => $data['price'] ?? $menuItem->price
            ]);
        } catch (\Exception $e) {
            throw new MenuItemNotUpdated($e);
        }
    }

    /**
     * @param MenuItem $menuItem
     * @return bool
     * @throws MenuItemNotDeleted
     */
    public function delete(MenuItem $menuItem): bool
    {
        try {
            return (bool)$menuItem->delete();
        } catch (\Exception $e) {
            throw new MenuItemNotDeleted($e);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return (bool)MenuItem::find($id);
    }

    /**
     * @param int $pp
     * @return LengthAwarePaginator
     */
    public function getAll(int $pp): LengthAwarePaginator
    {
        return MenuItem::paginate($pp);
    }
}
