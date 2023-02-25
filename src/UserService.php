<?php

declare(strict_types=1);

namespace Microservices;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Client\PendingRequest;

class UserService
{
    private $endpoint;

    public function __construct()
    {
        $this->endpoint = env('USERS_ENDPOINT');
    }

    /**
     * @return array
     */
    public function headers(): array
    {
        return [
            'Authorization' => request()->headers->get('Authorization')
        ];
    }

    /**
     * @return PendingRequest
     */
    public function request(): PendingRequest
    {
        return \Http::withHeaders($this->headers());
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        $json = $this->request()->get("{$this->endpoint}/user")->json();

        return new User($json);
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->request()->get("{$this->endpoint}/admin")->successful();
    }

    /**
     * @return bool
     */
    public function isInfluencer(): bool
    {
        return $this->request()->get("{$this->endpoint}/influencer")->successful();
    }

    /**
     * @param $ability
     * @param $arguments
     * @return Response
     * @throws AuthorizationException
     */
    public function allows($ability, $arguments)
    {
        return \Gate::forUser($this->getUser())->authorize($ability, $arguments);
    }

    /**
     * @param $page
     * @return array|mixed
     */
    public function all($page)
    {
        return $this->request()->get("{$this->endpoint}/users?page={$page}")->json();
    }

    /**
     * @param $id
     * @return User
     */
    public function get($id): User
    {
        $json = $this->request()->get("{$this->endpoint}/users/{$id}")->json();

        return new User($json);
    }

    /**
     * @param $data
     * @return User
     */
    public function create($data): User
    {
        $json = $this->request()->post("{$this->endpoint}/users", $data)->json();

        return new User($json);
    }

    /**
     * @param $id
     * @param $data
     * @return User
     */
    public function update($id, $data): User
    {
        $json = $this->request()->put("{$this->endpoint}/users/{$id}", $data)->json();

        return new User($json);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->request()->delete("{$this->endpoint}/users/{$id}")->successful();
    }
}