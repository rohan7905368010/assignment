<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessLayer\BoardLogic;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    public function index()
    {
        $boardObj = new BoardLogic(null);
        return $boardObj->index();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:30|min:5'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $boardObj = new BoardLogic($request->all());
        $board = $boardObj->store();

        return response()->json([
            'data' => $board
        ],201);
    }

    public function show($id)
    {
        $boardObj = new BoardLogic(null);
        return $boardObj->show($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:30|min:5'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $boardObj = new BoardLogic($request->all());
        $board = $boardObj->update($id);

        return response()->json([
            'data' => $board
        ],200);
    }

    public function destroy($id)
    {
        $boardObj = new BoardLogic(null);
        $response = $boardObj->destroy($id);

        return response()->json([
            'status' => $response
        ],200);
    }
}
