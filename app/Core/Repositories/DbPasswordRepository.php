<?php

namespace App\Core\Repositories;

use App\Models\Password;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class DbPasswordRepository implements PasswordRepositoryContract
{
    /**
     * @var User
     */
    private User $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user
            ?? ($this->user = auth()->user());
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->getUser()->passwords;
    }

    /**
     * @param int $passwordId
     * @return Password|null
     */
    public function findById(int $passwordId): ?Password
    {
        return $this->getUser()->passwords()
            ->whereId($passwordId)->first();
    }

    /**
     * @param array $validatedData
     * @return Password|Model
     */
    public function create(array $validatedData): Password
    {
        return $this->getUser()
            ->passwords()->create($validatedData);
    }

    /**
     * @param Password $password
     * @param array $data
     * @return bool
     */
    public function update(Password $password, array $data): bool
    {
        return $password->update($data);
    }

    /**
     * @param int $passwordId
     * @return int
     */
    public function destroy(int $passwordId): int
    {
        return $this->getUser()->passwords()
            ->whereId($passwordId)->delete();
    }
}
