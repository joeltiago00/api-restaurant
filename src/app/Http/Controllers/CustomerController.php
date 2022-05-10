<?php

namespace App\Http\Controllers;

use App\Core\Document;
use App\Exceptions\Custumer\CustumerNotStored;
use App\Exceptions\Customer\{CustomerNotChanged,
    CustomerNotCreated,
    CustomerNotDeleted,
    CustomerNotExcluded,
    CustomerNotListed,
    CustomerNotUpdated};
use App\Exceptions\General\NothingToUpdate;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CostumerRequest;
use App\Models\Customer;
use App\Transformers\{
    CustomerTransformer,
};
use App\Repositories\{
    CustomerRepository,
    Repository,
};
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new CustomerRepository();
    }

    /**
     * @param CostumerRequest $request
     * @return JsonResponse
     * @throws CustomerNotCreated
     * @throws CustumerNotStored
     */
    public function store(CostumerRequest $request): JsonResponse
    {
        $document = new Document($request->document['type'], $request->document['value']);

        $customer = new \App\Core\Person\Custumer($request->first_name, $request->last_name, $document, $request->email);

        if (!$model = $this->repository->store($customer))
            throw new CustomerNotCreated();

        return ResponseHelper::created(['id' => $model->id]);
    }

    /**
     * @param CostumerRequest $request
     * @param Customer $customer
     * @return JsonResponse
     * @throws CustomerNotChanged
     * @throws CustomerNotUpdated
     * @throws NothingToUpdate
     */
    public function update(CostumerRequest $request, Customer $customer): JsonResponse
    {
        if (!$this->repository->update($customer, $request->only(['first_name', 'last_name', 'document_value', 'email'])))
            throw new CustomerNotChanged();

        return ResponseHelper::noContent();
    }

    /**
     * @param CostumerRequest $request
     * @return JsonResponse
     * @throws CustomerNotListed
     */
    public function index(CostumerRequest $request): JsonResponse
    {
        if (!$customers = $this->repository->getAll($request->pp))
            throw new CustomerNotListed();

        return ResponseHelper::results((new CustomerTransformer())->index($customers->toArray()));
    }

    /**
     * @param Customer $customer
     * @return JsonResponse
     */
    public function show(Customer $customer): JsonResponse
    {
        return ResponseHelper::results((new CustomerTransformer())->show($customer->toArray()));
    }

    /**
     * @param Customer $customer
     * @return JsonResponse
     * @throws CustomerNotExcluded
     * @throws CustomerNotDeleted
     */
    public function delete(Customer $customer): JsonResponse
    {
        if (!$this->repository->delete($customer))
            throw new CustomerNotExcluded();

        return ResponseHelper::noContent();
    }
}
