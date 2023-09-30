<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        
    }

    public function store(StoreTaskRequest $request) : JsonResponse
    {
        $data = $request->validated() + [
            'created_by_user_id' => auth('sanctum')->user()->id
        ];

        $task = Task::create($data);

        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => __('Task Created.')
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task) : JsonResponse
    {
        $data = $request->validated();

        $task->update($data);

        return response()->json([
            'success' => true,
            'data'    => $task->refresh(),
            'message' => __('Task Updated.')
        ]);
    }

    public function delete(Task $task) : JsonResponse
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => __('Task Deleted.')
        ]);
    }

    public function show(Task $task) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => __('Task Deleted.')
        ]);
    }


}
