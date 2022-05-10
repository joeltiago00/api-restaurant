<?php

namespace App\Transformers;

class MenuItemTransformer
{

    public function index(array $collection)
    {
        $response['pagination'] = [
            'total' => $collection['total'],
            'per_page' => $collection['per_page'],
            'page' => $collection['page'] ?? 1,
            'next_page_url' => $collection['next_page_url'],
            'prev_page_url' => $collection['prev_page_url']
        ];

        foreach ($collection['data'] as $item) {
            $response['items'][] = $this->applyFormat($item['id'], $item['menu_id'], $item['name'], $item['price']);
        }

        return $response ?? [];
    }

    /**
     * @param array $item
     * @return array
     */
    public function show(array $item): array
    {
        return $this->applyFormat($item['id'], $item['menu_id'], $item['name'], $item['price']);
    }

    /**
     * @param int $id
     * @param int $menu_id
     * @param string $name
     * @param float $price
     * @return array
     */
    private function applyFormat(int $id,int $menu_id, string $name, float $price): array
    {
        return [
            'id' => $id,
            'menu_id' => $menu_id,
            'name' => $name,
            'price' => $price
        ];
    }
}
