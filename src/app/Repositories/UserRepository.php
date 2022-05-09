<?php

namespace App\Repositories;

use App\Core\Interfaces\UserInterface;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\Role\RoleNotFound;
use App\Exceptions\User\UserNotStored;
use App\Models\User;
use App\Types\JobFunctionTypes;
use App\Types\RoleTypes;
use Exception;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(User::class);
    }

    /**
     * @param UserInterface $employee
     * @return User
     * @throws JobFunctionNotFound
     * @throws RoleNotFound
     * @throws UserNotStored
     */
    public function store(UserInterface $employee): User
    {
        if (!(new RoleRepository())->exitsById($employee->getRole()))
            throw new RoleNotFound();

        if (!(new JobFunctionRepository())->exitsById($employee->getJobFunction()))
            throw new JobFunctionNotFound();

        try {
            return User::create([
                'first_name' => $employee->getFisrtName(),
                'last_name' => $employee->getLastName(),
                'document_type' => $employee->getDocumentType(),
                'document_value' => $employee->getDocumentValue(),
                'email' => $employee->getEmail(),
                'password' => $employee->getPassword(),
                'role_id' => $employee->getRole(),
                'job_function_id' => $employee->getJobFunction()
            ]);
        } catch (Exception $e) {
            throw new UserNotStored($e);
        }
    }

    /**
     * @param User $user
     * @return bool
     * @throws RoleNotFound
     */
    public function isAdmin(User $user): bool
    {
        if (!$role = (new RoleRepository())->getById($user->role_id))
            throw new RoleNotFound();

        return $role->name === RoleTypes::ADMIN;
    }

    /**
     * @param User $user
     * @return bool
     * @throws JobFunctionNotFound
     */
    public function isWaiter(User $user): bool
    {
        if (!$job_function = (new JobFunctionRepository())->getById($user->job_function_id))
            throw new JobFunctionNotFound();

        return $job_function->name === JobFunctionTypes::WAITER;
    }

    /**
     * @param User $user
     * @return bool
     * @throws JobFunctionNotFound
     */
    public function isCooker(User $user): bool
    {
        if (!$job_function = (new JobFunctionRepository())->getById($user->job_function_id))
            throw new JobFunctionNotFound();

        return $job_function->name === JobFunctionTypes::COOKER;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getById(int $id): User
    {
        return self::getModel()::find($id);
    }
}
