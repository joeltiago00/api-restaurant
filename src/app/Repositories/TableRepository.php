<?php

namespace App\Repositories;

use App\Core\Interfaces\TableInterface;
use App\Exceptions\General\NothingToUpdate;
use App\Exceptions\Table\TableNotDeleted;
use App\Exceptions\Table\TableNotStored;
use App\Exceptions\Table\TableNotUpdated;
use App\Models\Table;

class TableRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Table::class);
    }

    /**
     * @param TableInterface $table
     * @return Table
     * @throws TableNotStored
     */
    public function store(TableInterface $table): Table
    {
        try {
            return self::getModel()::create([
                'number' => $table->getNumber(),
                'quantity_seats' => $table->getQuantitySeats()
            ]);
        } catch (\Exception $e) {
            throw new TableNotStored($e);
        }
    }

    /**
     * @param Table $model
     * @param array $data
     * @return bool
     * @throws NothingToUpdate
     * @throws TableNotUpdated
     */
    public function update(Table $model, array $data): bool
    {
        if (empty($data))
            throw new NothingToUpdate();

        try {
            return $model->update([
                'number' => $data['number'] ?? $model->number,
                'quantity_seats' => $data['quantity_seats'] ?? $model->quantity_seats
            ]);
        } catch (\Exception $e) {
            throw new TableNotUpdated($e);
        }
    }

    /**
     * @param int $pp
     * @return mixed
     */
    public function getAll(int $pp)
    {
        return self::getModel()::paginate($pp);
    }

    /**
     * @param Table $table
     * @return bool
     * @throws TableNotDeleted
     */
    public function delete(Table $table): bool
    {
        try {
            return (bool)$table->delete();
        } catch (\Exception $e) {
            throw new TableNotDeleted($e);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return (bool)Table::find($id);
    }
}
