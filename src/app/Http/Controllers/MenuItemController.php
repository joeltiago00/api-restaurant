<?php

namespace App\Http\Controllers;

use App\Exceptions\General\NothingToUpdate;
use App\Exceptions\Menu\MenuItemNotChanged;
use App\Exceptions\Menu\MenuItemNotCreated;
use App\Exceptions\Menu\MenuItemNotDeleted;
use App\Exceptions\Menu\MenuItemNotExcluded;
use App\Exceptions\Menu\MenuItemNotListed;
use App\Exceptions\Menu\MenuItemNotStored;
use App\Exceptions\Menu\MenuItemNotUpdated;
use App\Exceptions\Menu\MenuNotFound;
use App\Helpers\ResponseHelper;
use App\Http\Requests\MenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Repositories\MenuItemRepository;
use App\Repositories\Repository;
use App\Transformers\MenuItemTransformer;
use App\Types\PaginationValueTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new MenuItemRepository();
    }

    /**
     * @param MenuItemRequest $request
     * @return JsonResponse
     * @throws MenuItemNotCreated
     * @throws MenuItemNotStored
     * @throws MenuNotFound
     */
    public function store(MenuItemRequest $request): JsonResponse
    {
        $menu = new \App\Core\Menu\Menu($request->menu_id);

        $menu_item = new \App\Core\Menu\MenuItem($menu, $request->name, $request->price);

        if (!$model = $this->repository->store($menu_item))
            throw new MenuItemNotCreated();

        return ResponseHelper::created(['id' => $model->id]);
    }

    /**
     * @param MenuItemRequest $request
     * @param MenuItem $menuItem
     * @return JsonResponse
     * @throws MenuItemNotChanged
     * @throws MenuNotFound
     * @throws NothingToUpdate
     * @throws MenuItemNotUpdated
     */
    public function update(MenuItemRequest $request, MenuItem $menuItem): JsonResponse
    {
        if (!$this->repository->update($menuItem, $request->only(['menu_id', 'name', 'price'])))
            throw new MenuItemNotChanged();

        return ResponseHelper::noContent();
    }

    /**
     * @param MenuItem $menuItem
     * @return JsonResponse
     */
    public function show(MenuItem $menuItem): JsonResponse
    {
        return ResponseHelper::results((new MenuItemTransformer())->show($menuItem->toArray()));
    }

    /**
     * @param MenuItemRequest $request
     * @return JsonResponse
     * @throws MenuItemNotListed
     */
    public function index(MenuItemRequest $request): JsonResponse
    {

        if (!$menu_items = $this->repository->getAll($request->pp ?? PaginationValueTypes::PER_PAGE_DEFAULT))
            throw new MenuItemNotListed();

        return ResponseHelper::results((new MenuItemTransformer())->index($menu_items->toarray()));
    }

    /**
     * @param MenuItem $menuItem
     * @return JsonResponse
     * @throws MenuItemNotExcluded
     * @throws MenuItemNotDeleted
     */
    public function delete(MenuItem $menuItem): JsonResponse
    {
        if (!$this->repository->delete($menuItem))
            throw new MenuItemNotExcluded();

        return ResponseHelper::noContent();
    }
}
