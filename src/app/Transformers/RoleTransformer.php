<?php

namespace App\Transformers;

class RoleTransformer
{
    /**
     * @param array $collection
     * @return array
     */
    public function index(array $collection): array
    {
        foreach ($collection as $job_function) {
            $job_functions[] = $this->applyFormat($job_function['id'], $job_function['name']);
        }

        return $job_functions ?? [];
    }

    /**
     * @param int $job_function_id
     * @param string $name
     * @return array
     */
    private function applyFormat(int $job_function_id, string $name): array
    {
        return [
            'id' => $job_function_id,
            'name' => $name
        ];
    }
}
