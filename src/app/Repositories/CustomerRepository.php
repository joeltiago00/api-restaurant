<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Interfaces\CustomerInterface;
use App\Exceptions\Customer\CustomerNotDeleted;
use App\Exceptions\Customer\CustomerNotUpdated;
use App\Exceptions\Custumer\CustumerNotStored;
use App\Exceptions\General\NothingToUpdate;
use App\Models\Customer;
use App\Models\Table;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Customer::class);
    }

    /**
     * @param CustomerInterface $costumer
     * @return Customer
     * @throws CustumerNotStored
     */
    public function store(CustomerInterface $costumer): Customer
    {
        try {
            return Customer::create([
                'first_name' => $costumer->getFisrtName(),
                'last_name' => $costumer->getLastName(),
                'document_type' => $costumer->getDocumentType(),
                'document_value' => $costumer->getDocumentValue(),
                'email' => $costumer->getEmail(),
            ]);
        } catch (\Exception $e) {
            throw new CustumerNotStored($e);
        }
    }

    /**
     * @param Customer $customer
     * @param array $data
     * @return bool
     * @throws CustomerNotUpdated
     * @throws NothingToUpdate
     */
    public function update(Customer $customer, array $data): bool
    {
        if (empty($data))
            throw new NothingToUpdate();

        try {
            return $customer->update([
                'first_name' => $data['first_name'] ?? $customer->first_name,
                'last_name' => $data['last_name'] ?? $customer->last_name,
                'document_value' => $data['document_value'] ?? $customer->document_value,
                'email' => $data['email'] ?? $customer->email,
            ]);
        } catch (\Exception $e) {
            throw new CustomerNotUpdated($e);
        }

    }

    /**
     * @param Customer $customer
     * @return bool
     * @throws CustomerNotDeleted
     */
    public function delete(Customer $customer): bool
    {
        try {
            return (bool)$customer->delete();
        } catch (\Exception $e) {
            throw new CustomerNotDeleted($e);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return (bool)Customer::find($id);
    }

    /**
     * @param int $pp
     * @return LengthAwarePaginator
     */
    public function getAll(int $pp): LengthAwarePaginator
    {
        return Customer::paginate($pp);
    }
}
