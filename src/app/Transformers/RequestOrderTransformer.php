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
            $items = isset($order['items']) ? $this->setItem($order['items']) : [];
            $customer = isset($order['customer']) ? $this->setCustomer($order['customer']) : [];
            $table = isset($order['table']) ? $this->setTable($order['table']) : [];
            $cooker = isset($order['cooker']) ? $this->setCooker($order['cooker']) : [];
            $waiter = isset($order['waiter']) ? $this->setWaiter($order['waiter']) : [];
            $response['request_orders'][] = $this->applyFormat($order, $items, $waiter, $cooker, $customer, $table);
        }

        return $response ?? [];
    }

    /**
     * @param array $collection
     * @return array
     */
    public function firstGreaterLess(array $collection): array
    {
        foreach ($collection as $key => $order) {
            $items = isset($order['items']) ? $this->setItem($order['items']) : [];
            $customer = isset($order['customer']) ? $this->setCustomer($order['customer']) : [];
            $table = isset($order['table']) ? $this->setTable($order['table']) : [];
            $cooker = isset($order['cooker']) ? $this->setCooker($order['cooker']) : [];
            $waiter = isset($order['waiter']) ? $this->setWaiter($order['waiter']) : [];

            $response[$key] = $this->applyFormat($order, $items, $waiter, $cooker, $customer, $table);
        }

        return $response ?? [];
    }

    /**
     * @param array $order
     * @return array
     */
    public function show(array $order): array
    {
        $items = isset($order[0]['items']) ? $this->setItem($order[0]['items']) : [];
        $customer = isset($order[0]['customer']) ? $this->setCustomer($order[0]['customer']) : [];
        $table =  isset($order[0]['table']) ? $this->setTable($order[0]['table']) : [];
        $cooker = isset($order[0]['cooker']) ? $this->setCooker($order[0]['cooker']) : [];
        $waiter = isset($order[0]['waiter']) ? $this->setWaiter($order[0]['waiter']) : [];

        return $this->applyFormat($order[0], $items, $waiter, $cooker, $customer, $table);
    }

    /**
     * @param array $data
     * @param array $items
     * @param array $waiter
     * @param array $cooker
     * @param array $customer
     * @param array $table
     * @return array
     */
    private function applyFormat(
        array $data,
        array $items,
        array $waiter,
        array $cooker,
        array $customer,
        array $table
    ): array
    {
        return [
            'id' => $data['id'],
            'waiter_id' => $data['waiter_id'],
            'cooker_id' => $data['cooker_id'],
            'total_price' => $data['price'],
            'table_id' => $data['table_id'],
            'status' => $data['status'],
            'created_at' => $data['created_at'],
            'started_at' => $data['started_at'],
            'finished_at' => $data['finished_at'],
            'waiter' => $waiter,
            'cooker' => $cooker,
            'table' => $table,
            'customer' => $customer,
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
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function setTable(array $data): array
    {
        return [
            'id' => $data['id'],
            'number'=> $data['number'],
            'quantity_seats' => $data['quantity_seats'],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function setCooker(array $data): array
    {
        return [
            'id' => $data['id'],
            'first_name'=> $data['first_name'],
            'last_name' => $data['last_name'],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function setCustomer(array $data): array
    {
        return [
            'id' => $data['id'],
            'first_name'=> $data['first_name'],
            'last_name' => $data['last_name'],
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
