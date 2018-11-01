<?php

namespace Goldoni\Builder\Entities;

/**
 * Class Demo.
 */
class Demo
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $firstName;
    /**
     * @var string
     */
    public $lastName;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $mobile;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $deletedAt;
    /**
     * @var string
     */
    public $createdAt;
    /**
     * @var string
     */
    public $updatedAt;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param null|string $datetime
     */
    public function setCreatedAt(?string $datetime = null): void
    {
        if (\is_string($datetime)) {
            $this->createdAt = new \DateTime($datetime);
        }
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param null|string $datetime
     */
    public function setUpdatedAt(?string $datetime = null): void
    {
        if (\is_string($datetime)) {
            $this->updatedAt = new \DateTime($datetime);
        }
    }

    /**
     * @return string
     */
    public function getDeletedAt(): string
    {
        return $this->deletedAt;
    }

    /**
     * @param null|string $datetime
     */
    public function setDeletedAt(?string $datetime = null): void
    {
        if (\is_string($datetime)) {
            $this->deletedAt = new \DateTime($datetime);
        }
    }
}
