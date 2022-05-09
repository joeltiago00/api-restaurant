<?php

namespace App\Http\Controllers;

use App\Core\Document;
use App\Core\Login;
use App\Core\Person\User;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\Role\RoleNotFound;
use App\Exceptions\User\UserNotStored;
use App\Helpers\ResponseHelper;
use App\Http\Requests\UserRequest;
use App\Repositories\JobFunctionRepository;
use App\Repositories\{
    Repository,
    RoleRepository,
    UserRepository,
};
use App\Transformers\{
    JobFunctionTransformer,
    RoleTransformer
};
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
}
