<?php

/**
 * Base User class - defines the contract for all user types
 * Following Liskov Substitution Principle (LSP)
 */
abstract class User
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $userType;
    protected $createdAt;
    protected $isActive;

    public function __construct($id, $firstName, $lastName, $email, $userType = 'regular')
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userType = $userType;
        $this->isActive = true;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    // Common methods that all user types must implement
    abstract public function getPermissions(): array;
    abstract public function canAccess(string $resource): bool;
    abstract public function getDisplayName(): string;

    // Common methods with default implementation (can be overridden)
    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    // Template method - defines the algorithm structure
    public function login(): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        return $this->performLogin();
    }

    // Hook method for subclasses to customize login behavior
    protected function performLogin(): bool
    {
        return true; // Default implementation
    }

    // Common validation method
    public function validateData(): bool
    {
        return !empty($this->email) && 
               !empty($this->firstName) && 
               !empty($this->lastName) &&
               filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    // Method to get user data as array
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'userType' => $this->userType,
            'isActive' => $this->isActive,
            'createdAt' => $this->createdAt
        ];
    }
}
