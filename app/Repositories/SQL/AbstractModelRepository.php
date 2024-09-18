<?php

namespace App\Repositories\SQL;

use App\Repositories\Contracts\IModelRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractModelRepository implements IModelRepository
{
    public function __construct(protected Model $model)
    {
    }

    public function all($columns = ['*']): Collection
    {
        return $this->model->get();
    }

    public function store(array $data): object
    {
        return $this->model->create($data);
    }

    public function find(int $id, $columns = ['*']): Model
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function destroy(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function withRelations(array $relations): Builder
    {
        return  $this->model->with($relations);
    }

    public function paginate(int $perPage = 10): object
    {
        $this->model = $this->model->paginate($perPage);
        return $this;
    }
}
