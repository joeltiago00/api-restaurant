<?php

namespace App\Transformers;

class TableTransformer
{
    /**
     * @param array $collection
     * @return array
     */
    public function index(array $collection): array
    {
        $response['pagination'] = [
            'total' => $collection['total'],
            'per_page' => $collection['per_page'],
            'page' => $collection['page'] ?? 1,
            'next_page_url' => $collection['next_page_url'],
            'prev_page_url' => $collection['prev_page_url']
        ];

        foreach ($collection['data'] as $table) {
            $response['tables'][] = $this->applyFormat($table['id'], $table['number'], $table['quantity_seats']);
        }

        return $response ?? [];
    }

    /**
     * @param array $table
     * @return array
     */
    public function show(array $table): array
    {
        return $this->applyFormat($table['id'], $table['number'], $table['quantity_seats']);
    }

    /**
     * @param int $table_id
     * @param int $number
     * @param int $quantity_seats
     * @return int[]
     */
    private function applyFormat(int $table_id, int $number, int $quantity_seats): array
    {
        return [
            'id' => $table_id,
            'number' => $number,
            'quantity_seats' => $quantity_seats
        ];
    }
}
