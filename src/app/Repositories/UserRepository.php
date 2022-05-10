<?php

namespace App\Repositories;

use App\Core\Interfaces\UserInterface;
use App\Exceptions\General\NothingToUpdate;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\Role\RoleNotFound;
use App\Exceptions\User\InvalidUser;
use App\Exceptions\User\UserNotDeleted;
use App\Exceptions\User\UserNotStored;
use App\Exceptions\User\UserNotUpdated;
use App\Models\User;
use App\Types\JobFunctionTypes;
use App\Types\RoleTypes;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
     * @param array $data
     * @return bool
     * @throws NothingToUpdate
     * @throws UserNotUpdated
     */
    public function update(User $user, array $data): bool
    {
        if (empty($data))
            throw new NothingToUpdate();

        try {
            return $user->update([
                'first_name' => $data['first_name'] ?? $user->first_name,
                'last_name' => $data['last_name'] ?? $user->last_name,
            ]);
        } catch (Exception $e) {
            throw new UserNotUpdated($e);
        }
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserNotDeleted
     */
    public function delete(User $user): bool
    {
        try {
            return (bool)$user->delete();
        } catch (Exception $e) {
            throw new UserNotDeleted($e);
        }
    }

    /**
     * @param $user
     * @return bool
     * @throws RoleNotFound
     */
    public function isAdmin($user): bool
    {
        if ($user instanceof User) {
            if (!$role = (new RoleRepository())->getById($user->role_id))
                throw new RoleNotFound();
        } else {
            if (!$role = (new RoleRepository())->getById((int)$user))
                throw new RoleNotFound();
        }

        return $role->name === RoleTypes::ADMIN;
    }

    /**
     * @param $user
     * @return bool
     * @throws JobFunctionNotFound
     */
    public function isWaiter($user): bool
    {
        if ($user instanceof User) {
            if (!$job_function = (new JobFunctionRepository())->getById($user->job_function_id))
                throw new JobFunctionNotFound();
        } else {
            if (!$user = $this->getById((int)$user))
            throw new InvalidUser();

            if (!$job_function = (new JobFunctionRepository())->getById($user->job_function_id))
                throw new JobFunctionNotFound();
        }

        return $job_function->name === JobFunctionTypes::WAITER;
    }

    /**
     * @param $user
     * @return bool
     * @throws JobFunctionNotFound
     */
    public function isCooker($user): bool
    {
        if ($user instanceof User) {
            if (!$job_function = (new JobFunctionRepository())->getById($user->job_function_id))
                throw new JobFunctionNotFound();
        } else {
            if (!$job_function = (new JobFunctionRepository())->getById((int)$user))
                throw new JobFunctionNotFound();
        }

        return $job_function->name === JobFunctionTypes::COOKER;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getById(int $id): User
    {
        return User::find($id);
    }

    /**
     * @param int $pp
     * @return LengthAwarePaginator
     */
    public function getAll(int $pp): LengthAwarePaginator
    {
        return User::paginate($pp);
    }
}
