<?php

namespace App\Core\Repositories;

use App\Models\Password;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PasswordRepositoryContract
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $passwordId
     * @return Password|null
     */
    public function findById(int $passwordId): ?Password;

    /**
     * @param array $validatedData
     * @return Model|Password
     */
    public function create(array $validatedData): Password;

    /**
     * @param Password $password
     * @param array $data
     * @return bool
     */
    public function update(Password $password, array $data): bool;

    /**
     * @param int $passwordId
     * @return int
     */
    public function destroy(int $passwordId): int;
}
