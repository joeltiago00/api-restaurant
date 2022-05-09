<?php

namespace App\Http\Controllers;

use App\Exceptions\General\NothingToUpdate;
use App\Transformers\TableTransformer;
use App\Types\PaginationValueTypes;
use App\Exceptions\Table\{TableNotChanged,
    TableNotCreated,
    TableNotDeleted,
    TableNotGeted,
    TableNotStored,
    TableNotUpdated};
use App\Helpers\ResponseHelper;
use App\Http\Requests\TableRequest;
use App\Models\Table;
use App\Repositories\{
    Repository,
    TableRepository,
};
use Illuminate\Http\JsonResponse;

class TableController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new TableRepository();
    }

    /**
     * @param TableRequest $request
     * @return JsonResponse
     * @throws TableNotCreated
     * @throws TableNotStored
     */
    public function store(TableRequest $request): JsonResponse
    {
        $table = new \App\Core\Table\Table($request->number, $request->quantity_seats);

        if (!$model = $this->repository->store($table))
            throw new TableNotCreated();

        return ResponseHelper::created(['id' => $model->id]);
    }

    /**
     * @param TableRequest $request
     * @param Table $table
     * @return JsonResponse
     * @throws TableNotChanged
     * @throws NothingToUpdate
     * @throws TableNotUpdated
     */
    public function update(TableRequest $request, Table $table): JsonResponse
    {
        if (!$this->repository->update($table, $request->only(['number', 'quantity_seats'])))
            throw new TableNotChanged();

        return ResponseHelper::noContent();
    }

    /**
     * @param Table $table
     * @return JsonResponse
     */
    public function show(Table $table): JsonResponse
    {
        return ResponseHelper::results((new TableTransformer())->show($table->toArray()));
    }

    /**
     * @param TableRequest $request
     * @return JsonResponse
     * @throws TableNotGeted
     */
    public function index(TableRequest $request): JsonResponse
    {
        if (!$tables = $this->repository->getAll($request->pp ?? PaginationValueTypes::PER_PAGE_DEFAULT))
            throw new TableNotGeted();

        return ResponseHelper::results((new TableTransformer())->index($tables->toArray()));
    }

    /**
     * @param Table $table
     * @return JsonResponse
     * @throws TableNotDeleted
     */
    public function delete(Table $table): JsonResponse
    {
        if (!$this->repository->delete($table))
            throw new TableNotDeleted();

        return ResponseHelper::noContent();
    }
}
