<?php

namespace App\Core\Interfaces;

interface DocumentInterface
{
    public function getDocumentType(): string;

    public function getDocumentValue(): string;
}
