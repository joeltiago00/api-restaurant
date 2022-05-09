<?php

namespace App\Core;

use App\Core\Interfaces\LoginInterface;
use Illuminate\Support\Facades\Hash;

class Login implements LoginInterface
{
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = Hash::make($password, ['rounds' => 12]);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
