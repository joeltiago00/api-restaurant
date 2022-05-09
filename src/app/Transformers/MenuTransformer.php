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
        foreach ($collection as $menu) {
            $items = $this->setItem($menu['items']);
            $menus[] = $this->applyFormat($menu['id'], $menu['name'], $items);
        }

        return $menus ?? [];
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
