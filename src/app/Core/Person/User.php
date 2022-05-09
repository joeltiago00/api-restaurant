<?php

namespace App\Core\Person;

use App\Core\Interfaces\DocumentInterface;
use App\Core\Interfaces\LoginInterface;
use App\Core\Interfaces\UserInterface;

class User implements UserInterface
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
     * @var int
     */
    private int $role;
    /**
     * @var int
     */
    private int $jobFunction;
    /**
     * @var LoginInterface
     */
    private LoginInterface $login;

    /**
     * @param string $first_name
     * @param string $last_name
     * @param DocumentInterface $document
     * @param int $role
     * @param int $job_function
     * @param LoginInterface $login
     */
    public function __construct(
        string $first_name,
        string $last_name,
        DocumentInterface $document,
        int $role,
        int $job_function,
        LoginInterface $login
    )
    {
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->document = $document;
        $this->role = $role;
        $this->jobFunction = $job_function;
        $this->login = $login;
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
        return $this->login->getEmail();
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getJobFunction(): int
    {
        return $this->jobFunction;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->login->getPassword();
    }
}
