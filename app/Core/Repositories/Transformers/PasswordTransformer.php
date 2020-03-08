<?php

namespace App\Core\Repositories\Transformers;

use App\Http\RoutesInfo\V1\PasswordInfo;
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
            PasswordInfo::Id => $password->id,
            PasswordInfo::UserId => $password->user_id,
            PasswordInfo::Name => $password->name,
            PasswordInfo::Username => $password->username,
            PasswordInfo::Website => $password->website,
            PasswordInfo::Note => $password->note,
            PasswordInfo::Value => '**************',
            PasswordInfo::CreatedAt => $password->created_at->diffForHumans(),

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
