<?php

namespace App\Repositories\SQL;

use App\Models\Todo;
use App\Repositories\Contracts\ITodoRepository;

class TodoRepository extends AbstractModelRepository implements ITodorepository
{
    public function __construct(Todo $model)
    {
        parent::__construct($model);
    }
}
