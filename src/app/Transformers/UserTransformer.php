<?php

namespace App\Transformers;

class UserTransformer
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

        foreach ($collection['data'] as $user) {
            $response['users'][] = $this->applyFormat(
                $user['id'],
                $user['first_name'],
                $user['last_name'],
                $user['email'],
                $user['role_id'],
                $user['job_function_id']
            );
        }

        return $response ?? [];
    }
    /**
     * @param array $user
     * @return array
     */
    public function show(array $user): array
    {
        return $this->applyFormat(
            $user['id'],
            $user['first_name'],
            $user['last_name'],
            $user['email'],
            $user['role_id'],
            $user['job_function_id']
        );
    }

    /**
     * @param int $id
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param int $role_id
     * @param int $job_function_id
     * @return array
     */
    private function applyFormat(
        int $id,
        string $first_name,
        string $last_name,
        string $email,
        int $role_id,
        int $job_function_id
    ): array
    {
        return [
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'role_id' => $role_id,
            'job_function_id' => $job_function_id
        ];
    }
}
