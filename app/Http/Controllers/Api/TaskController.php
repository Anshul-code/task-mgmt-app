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
    /**
     * List all tasks assigned to authenticated user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $authUser = auth('sanctum')->user();
        
        $data = Task::where(function($query) use($request, $authUser) {
                        return $query->when(in_array($request->type, ['assigned-to-me', 'all']), function($queryWhen) use($authUser) {
                                        return $queryWhen->whereHas('users', function($q) use($authUser) {
                                            return $q->where('user_id', $authUser->id);
                                        });
                                    })
                                    ->when(in_array($request->type, ['created-by-me', 'all']), function($queryWhen) use($authUser) {
                                        return $queryWhen->orWhereHas('createdBy', function($q) use($authUser) {
                                            return $q->where('created_by_user_id', $authUser->id);
                                        });
                                    });
                    })
                    ->when($request->status, function($q) use($request) {
                        return $q->where('status', $request->status);
                    })
                    ->latest()
                    ->with([
                        'createdBy' => function($q) {
                            return $q->select('id','name');
                        },
                    ])
                    ->paginate($request->per_page ?: 10);
                    

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store new task
     *
     * @param \App\Http\Requests\StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request) : JsonResponse
    {
        $data = $request->validated() + [
            'created_by_user_id' => auth('sanctum')->user()->id
        ];

        unset($data['assinees']);

        $task = Task::create($data);

        $task->users()->attach($request->assinees ? : []);

        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => __('Task Created.')
        ]);
    }

    /**
     * Update new task
     *
     * @param \App\Http\Requests\UpdateTaskRequest $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task) : JsonResponse
    {
        $data = $request->validated();

        unset($data['assinees']);

        $task->update($data);

        $task->users()->sync($request->assinees ? : []);

        return response()->json([
            'success' => true,
            'data'    => $task->refresh(),
            'message' => __('Task Updated.')
        ]);
    }

    /**
     * Delete task
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Task $task) : JsonResponse
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => __('Task Deleted.')
        ]);
    }

    /**
     * Show particular task
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => __('Task Deleted.')
        ]);
    }


}
