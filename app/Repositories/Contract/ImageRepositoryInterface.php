<?php

namespace App\Repositories\Contract;

use Illuminate\Database\Eloquent\Model;

interface ImageRepositoryInterface
{
    public function attach(Model $model, string $relation, array $images = [], string $directory = null): void;
}
