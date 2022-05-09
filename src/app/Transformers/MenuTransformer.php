<?php

namespace App\Transformers;

class MenuTransformer
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

        foreach ($collection['data'] as $menu) {
            $response['menus'][] = $this->applyFormat($menu['id'], $menu['name']);
        }

        return $response ?? [];
    }

    /**
     * @param array $collection
     * @return array
     */
    public function list(array $collection): array
    {
        foreach ($collection as $menu) {
            $items = $this->setItem($menu['items']);
            $menus[] = array_merge($this->applyFormat($menu['id'], $menu['name']), $items);
        }

        return $menus ?? [];
    }

    /**
     * @param array $menu
     * @return array
     */
    public function show(array $menu): array
    {
        $items = $this->setItem($menu['items']);

        return $this->applyFormat($menu['id'], $menu['name'], $items);
    }

    /**
     * @param int $menu_id
     * @param string $menu_name
     * @return array
     */
    private function applyFormat(int $menu_id, string $menu_name): array
    {
        return [
            'id' => $menu_id,
            'name' => $menu_name,
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
