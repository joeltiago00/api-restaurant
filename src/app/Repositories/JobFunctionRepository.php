<?php

namespace App\Repositories;

use App\Models\JobFunction;
use Illuminate\Database\Eloquent\Collection;

class JobFunctionRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(JobFunction::class);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return JobFunction::all();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exitsById(int $id): bool
    {
        return (bool)JobFunction::find($id);
    }

    /**
     * @param int $id
     * @return JobFunction
     */
    public function getById(int $id): JobFunction
    {
        return JobFunction::find($id);
    }

    /**
     * @param string $name
     * @return JobFunction
     */
    public function getByName(string $name): JobFunction
    {
        return JobFunction::where('name', $name)->first();
    }
}
