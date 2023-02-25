<?php

declare(strict_types=1);

namespace Microservices;

class User
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $email;
    public bool $is_influencer;

    public function __construct($json)
    {
        $this->id = $json['id'];
        $this->first_name = $json['first_name'];
        $this->last_name = $json['last_name'];
        $this->email = $json['email'];
        $this->is_influencer = $json['is_influencer'] ?? 0;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_influencer === 0;
    }

    /**
     * @return bool
     */
    public function isInfluencer(): bool
    {
        return $this->is_influencer === 1;
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}