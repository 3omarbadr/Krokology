<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ITodoRepository;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct(protected ITodoRepository $todoRepository)
    {
    }
}
