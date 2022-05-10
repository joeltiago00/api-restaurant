<?php

namespace App\Http\Controllers;

use App\Exceptions\Menu\{
    MenuNotChanged,
    MenuNotCreated,
    MenuNotDeleted,
    MenuNotExcluded,
    MenuNotGeted,
    MenuNotStored,
    MenuNotUpdated,
};
use App\Helpers\ResponseHelper;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Repositories\{
    MenuRepository,
    Repository
};
use App\Transformers\MenuTransformer;
use App\Types\PaginationValueTypes;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new MenuRepository();
    }

    /**
     * @param MenuRequest $request
     * @return JsonResponse
     * @throws MenuNotCreated
     * @throws MenuNotStored
     */
    public function store(MenuRequest $request): JsonResponse
    {
        $menu = new \App\Core\Menu\Menu(0, $request->name);

        if (!$model = $this->repository->store($menu))
            throw new MenuNotCreated();

        return ResponseHelper::created(['id' => $model->id]);
    }

    /**
     * @param MenuRequest $request
     * @param Menu $menu
     * @return JsonResponse
     * @throws MenuNotChanged
     * @throws MenuNotUpdated
     */
    public function update(MenuRequest $request, Menu $menu): JsonResponse
    {
        if (!$this->repository->update($menu, $request->name))
            throw new MenuNotChanged();

        return ResponseHelper::noContent();
    }

    /**
     * @param Menu $menu
     * @return JsonResponse
     * @throws MenuNotGeted
     */
    public function show(Menu $menu): JsonResponse
    {

        if (!$menu = $this->repository->getWithItemByMenuId($menu->id)->toArray())
            throw new MenuNotGeted();

        return ResponseHelper::results((new MenuTransformer())->show($menu));
    }

    /**
     * @param MenuRequest $request
     * @return JsonResponse
     * @throws MenuNotGeted
     */
    public function index(MenuRequest $request): JsonResponse
    {
        if (!$menus = $this->repository->getAll($request->pp ?? PaginationValueTypes::PER_PAGE_DEFAULT))
            throw new MenuNotGeted();

        return ResponseHelper::results((new MenuTransformer())->index($menus->toArray()));
    }

    /**
     * @param Menu $menu
     * @return void
     * @throws MenuNotExcluded
     * @throws MenuNotDeleted
     */
    public function delete(Menu $menu)
    {
        if (!$this->repository->delete($menu))
            throw new MenuNotExcluded();
    }
}
