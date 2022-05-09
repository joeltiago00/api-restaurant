<?php

namespace App\Core;

use App\Core\Interfaces\DocumentInterface;

class Document implements DocumentInterface
{
    /**
     * @var string
     */
    private string $type;
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $type
     * @param string $value
     */
    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getDocumentType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDocumentValue(): string
    {
        return $this->value;
    }
}
