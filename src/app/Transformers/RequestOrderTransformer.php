<?php

namespace App\Transformers;

class RequestOrderTransformer
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

        foreach ($collection['data'] as $order) {
            $waiter = $this->setWaiter($order['waiter']);
            $items = $this->setItem($order['items']);
            $response['request_orders'][] = $this->applyFormat($order, $items, $waiter);
        }

        return $response ?? [];
    }

    /**
     * @param array $data
     * @param array $items
     * @param array $waiter
     * @return array
     */
    private function applyFormat(array $data, array $items, array $waiter): array
    {
        return [
            'id' => $data['id'],
            'waiter_id' => $data['waiter_id'],
            'cooker_id' => $data['cooker_id'],
            'total_price' => $data['price'],
            'status' => $data['status'],
            'created_at' => $data['created_at'],
            'started_at' => $data['started_at'],
            'finished_at' => $data['finished_at'],
            'waiter' => $waiter,
            'items' => $items
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function setWaiter(array $data): array
    {
        return [
            'id' => $data['id'],
            'first_name'=> $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
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
                'price' => $item['price'],
                'name' => $item['name'],
                'menu_id' => $item['menu_id'],
            ];
        }

        return $items ?? [];
    }
}
