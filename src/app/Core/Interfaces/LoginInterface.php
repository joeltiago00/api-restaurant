<?php

namespace App\Core\Interfaces;

interface LoginInterface
{
    public function getEmail(): string;

    public function getPassword(): string;
}
