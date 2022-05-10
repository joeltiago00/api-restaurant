<?php

namespace App\Transformers;

class MenuTransformer
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

        foreach ($collection['data'] as $menu) {
            $items = isset($menu['items']) ? $this->setItem($menu['items']) : [];

            $response['menus'][] = $this->applyFormat($menu['id'], $menu['name'], $items);
        }

        return $response ?? [];
    }

    /**
     * @param array $collection
     * @return array
     */
    public function list(array $collection): array
    {
        $response['pagination'] = [
            'total' => $collection['total'],
            'per_page' => $collection['per_page'],
            'page' => $collection['page'] ?? 1,
            'next_page_url' => $collection['next_page_url'],
            'prev_page_url' => $collection['prev_page_url']
        ];

        foreach ($collection['data'] as $menu) {
            $items = isset($menu['items']) ? $this->setItem($menu['items']) : [];
            $response['menus'][] = $this->applyFormat($menu['id'], $menu['name'], $items);
        }

        return $response ?? [];
    }

    /**
     * @param array $menu
     * @return array
     */
    public function show(array $menu): array
    {
        $items = isset($menu['items']) ? $this->setItem($menu['items']) : [];

        return $this->applyFormat($menu['id'], $menu['name'], $items);
    }

    /**
     * @param int $menu_id
     * @param string $menu_name
     * @param array $items
     * @return array
     */
    private function applyFormat(int $menu_id, string $menu_name, array $items): array
    {
        return [
            'id' => $menu_id,
            'name' => $menu_name,
            'items' => $items
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function setItem(array $data): array
    {
        foreach ($data as $item) {
            $items[] = [
                'item_id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price']
            ];
        }

        return $items ?? [];
    }
}
