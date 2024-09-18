<?php

namespace App\Repositories\Contracts;

interface IModelRepository
{
    public function all($columns = ['*']);

    public function find(int $id, $columns = ['*']);

    public function store(array $data);

    public function update(int $id, array $data);

    public function destroy(int $id);

    public function withRelations(array $relations);

    public function paginate(int $perPage = 10);
}
