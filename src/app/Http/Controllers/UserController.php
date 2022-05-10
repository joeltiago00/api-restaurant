<?php

namespace App\Http\Controllers;

use App\Core\Document;
use App\Core\Login;
use App\Core\Person\User;
use App\Exceptions\General\NothingToUpdate;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\Role\RoleNotFound;
use App\Exceptions\User\UserNotChanged;
use App\Exceptions\User\UserNotDeleted;
use App\Exceptions\User\UserNotExcluded;
use App\Exceptions\User\UserNotListed;
use App\Exceptions\User\UserNotStored;
use App\Exceptions\User\UserNotUpdated;
use App\Helpers\ResponseHelper;
use App\Http\Requests\UserRequest;
use App\Repositories\JobFunctionRepository;
use App\Types\PaginationValueTypes;
use App\Repositories\{
    Repository,
    RoleRepository,
    UserRepository,
};
use App\Transformers\{JobFunctionTransformer, RoleTransformer, UserTransformer};
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     * @throws UserNotStored
     * @throws JobFunctionNotFound
     * @throws RoleNotFound
     */
    public function store(UserRequest $request): JsonResponse
    {
        $login = new Login($request->email, $request->password);

        $document = new Document($request->document['type'], $request->document['value']);

        $employee = new User(
            $request->first_name,
            $request->last_name,
            $document,
            $request->role_id,
            $request->job_function_id,
            $login
        );

        $model = $this->repository->store($employee);

        return ResponseHelper::created(['id' => $model->id]);
    }

    /**
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $roles = (new RoleRepository())->getAll();
        $job_functions = (new JobFunctionRepository())->getAll();

        return ResponseHelper::results([
            'roles' => (new RoleTransformer())->index($roles->toArray()),
            'job_functions' => (new JobFunctionTransformer())->index($job_functions->toArray())
        ]);
    }

    /**
     * @param UserRequest $request
     * @param \App\Models\User $user
     * @return JsonResponse
     * @throws UserNotChanged
     * @throws NothingToUpdate
     * @throws UserNotUpdated
     */
    public function update(UserRequest $request, \App\Models\User $user): JsonResponse
    {
        if (!$this->repository->update($user, $request->only(['first_name', 'last_name'])))
            throw new UserNotChanged();

        return ResponseHelper::noContent();
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     * @throws UserNotListed
     */
    public function index(UserRequest $request): JsonResponse
    {
        if (!$users = $this->repository->getAll($request->pp ?? PaginationValueTypes::PER_PAGE_DEFAULT))
            throw new UserNotListed();

        return ResponseHelper::results((new UserTransformer())->index($users->toArray()));
    }

    /**
     * @param \App\Models\User $user
     * @return JsonResponse
     */
    public function show(\App\Models\User $user): JsonResponse
    {
        return ResponseHelper::results((new UserTransformer())->show($user->toArray()));
    }

    /**
     * @param \App\Models\User $user
     * @return JsonResponse
     * @throws UserNotExcluded
     * @throws UserNotDeleted
     */
    public function delete(\App\Models\User $user): JsonResponse
    {
        if (!$this->repository->delete($user))
            throw new UserNotExcluded();

        return ResponseHelper::noContent();
    }
}
