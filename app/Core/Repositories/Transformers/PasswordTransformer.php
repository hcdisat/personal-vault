<?php

namespace App\Core\Repositories\Transformers;

use App\Models\Password;
use Traversable;

class PasswordTransformer
{
    /**
     * @param Password $password
     * @return array
     */
    public function transform(Password $password): array
    {
        return [
            'id' => $password->id,
            'name' => $password->name,
            'password' => $password->value
        ];
    }

    /**
     * @param iterable $collection
     * @return array
     */
    public function transformMany(iterable $collection): array
    {
        return collect($collection)
            ->map(fn(Password $p) => $this->transform($p))
            ->toArray();
    }
}
