<?php

namespace App\Http\Controllers;

use App\Enums\TodoStatus;
use App\Http\Requests\TodoRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Models\User;
use App\Notifications\TodoNotification;
use App\Repositories\Contracts\ITodoRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    use ApiResponse;
    public function __construct(protected ITodoRepository $todoRepository)
    {
    }

    public function index()
    {
        $todos = $this->todoRepository->withRelations(['assignedTo:id,name', 'assignedBy:id,name'])->paginate(10);
        return $this->successResponse(TodoResource::collection($todos), 'Todos retrieved successfully');
    }

    public function store(TodoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('todos', 'public');
        }

        $data['assigned_by'] = auth()->id();
        $data['status'] = $data['status'] ?? TodoStatus::PENDING->value;

        $todo = $this->todoRepository->store($data);

        return $this->successResponse(new TodoResource($todo), 'Todo created successfully', 201);
    }

    public function show($id)
    {
        $todo = $this->todoRepository->find($id);

        if (!$todo) {
            return $this->errorResponse(['message' => 'Todo not found'], 404);
        }

        return new TodoResource($todo);
    }

    public function update(TodoUpdateRequest $request, $id)
    {
        $todo = $this->todoRepository->find($id);

        if (!$todo) {
            return $this->errorResponse(['message' => 'Todo not found'], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($todo->image && file_exists(storage_path("app/public/{$todo->image}"))) {
                unlink(storage_path("app/public/{$todo->image}"));
            }
            $data['image'] = $request->file('image')->store('todos', 'public');
        }

        $updatedData = array_merge($todo->toArray(), $data);

        $this->todoRepository->update($id, $updatedData);

        return $this->successResponse(new TodoResource($todo), 'Todo updated successfully');
    }

    public function destroy($id)
    {
        $this->todoRepository->destroy($id);
        return $this->successResponse(null, 'Todo deleted successfully', 200);
    }
}
