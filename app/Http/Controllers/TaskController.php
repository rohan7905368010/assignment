<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessLayer\TaskLogic;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $taskObj = new TaskLogic($request->all());
        return $taskObj->index();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:30|min:5',
            'board_id' => 'required|numeric'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $taskObj = new TaskLogic($request->all());
        $task = $taskObj->store();

        return response()->json([
            'data' => $task
        ],201);
    }

    public function show($id)
    {
        $taskObj = new TaskLogic(null);
        return $taskObj->show($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:30|min:5',
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $taskObj = new TaskLogic($request->all());
        $board = $taskObj->update($id);

        return response()->json([
            'data' => $board
        ],200);
    }

    public function destroy($id)
    {
        $taskObj = new TaskLogic(null);
        $response = $taskObj->destroy($id);

        return response()->json([
            'status' => $response
        ],200);
    }
}
