<?php

namespace App\Transformers;

class CustomerTransformer
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

        foreach ($collection['data'] as $customer) {
            $response['customers'][] = $this->applyFormat(
                $customer['id'],
                $customer['first_name'],
                $customer['last_name'],
                $customer['email'],
                $customer['document_value']
            );
        }

        return $response ?? [];
    }
    /**
     * @param array $customer
     * @return array
     */
    public function show(array $customer): array
    {
        return $this->applyFormat(
            $customer['id'],
            $customer['first_name'],
            $customer['last_name'],
            $customer['email'],
            $customer['document_value']
        );
    }

    /**
     * @param int $id
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $document_value
     * @return array
     */
    private function applyFormat(
        int $id,
        string $first_name,
        string $last_name,
        string $email,
        string $document_value,
    ): array
    {
        return [
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'document_value' => $document_value,
        ];
    }
}
