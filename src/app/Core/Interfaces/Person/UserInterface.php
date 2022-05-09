<?php

namespace App\Core\Interfaces\Person;

interface UserInterface
{
    public function getFisrtName(): string;

    public function getLastName(): string;

    public function getDocumentType(): string;

    public function getDocumentValue(): string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getRole(): int;

    public function getJobFunction(): int;
}
