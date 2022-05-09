<?php

namespace App\Transformers;

class JobFunctionTransformer
{
    /**
     * @param array $collection
     * @return array
     */
    public function index(array $collection): array
    {
        foreach ($collection as $role) {
            $roles[] = $this->applyFormat($role['id'], $role['name']);
        }

        return $roles ?? [];
    }

    /**
     * @param int $role_id
     * @param string $name
     * @return array
     */
    private function applyFormat(int $role_id, string $name): array
    {
        return [
            'id' => $role_id,
            'name' => $name
        ];
    }
}
