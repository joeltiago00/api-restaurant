<?php

namespace App\Core\Interfaces;

interface CostumerInterface
{
    public function getFisrtName(): string;

    public function getLastName(): string;

    public function getDocumentType(): string;

    public function getDocumentValue(): string;

    public function getEmail(): string;
}
