<?php

namespace App\Core\Person;

use App\Core\Interfaces\CostumerInterface;
use App\Core\Interfaces\DocumentInterface;

class Costumer implements  CostumerInterface
{
    /**
     * @var string
     */
    private string $firstName;
    /**
     * @var string
     */
    private string $lastName;
    /**
     * @var DocumentInterface
     */
    private DocumentInterface $document;
    /**
     * @var string
     */
    private string $email;

    /**
     * @param string $first_name
     * @param string $last_name
     * @param DocumentInterface $document
     * @param string $email
     */
    public function __construct(string $first_name, string $last_name, DocumentInterface $document, string $email)
    {
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->document = $document;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFisrtName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getDocumentType(): string
    {
        return $this->document->getDocumentType();
    }

    /**
     * @return string
     */
    public function getDocumentValue(): string
    {
        return $this->document->getDocumentValue();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
