<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Interfaces\Person\CostumerInterface;
use App\Exceptions\Costumer\CostumerNotStored;
use App\Models\Costumer;

class CostumerRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Costumer::class);
    }

    /**
     * @param CostumerInterface $costumer
     * @return Costumer
     * @throws CostumerNotStored
     */
    public function store(CostumerInterface $costumer): Costumer
    {
        try {
            return self::getModel()::create([
                'first_name' => $costumer->getFisrtName(),
                'last_name' => $costumer->getLastName(),
                'document_type' => $costumer->getDocumentType(),
                'document_value' => $costumer->getDocumentValue(),
                'email' => $costumer->getEmail(),
            ]);
        } catch (\Exception $e) {
            throw new CostumerNotStored($e);
        }
    }
}
