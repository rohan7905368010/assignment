<?php

namespace App\BusinessLayer;

use App\Board;
use App\Task;

class BoardLogic
{
    public $requestData;
    public function __construct($_request) 
    {
        $this->requestData = $_request;
    }

    public function index()
    {
        $board = Board::where('user_id',auth()->user()['id'])->get()->toArray();
        return $board;
    }

    public function store()
    {
        $board = new Board;
        $board->title = $this->requestData['title'];
        $board->user_id = auth()->user()['id'];

        $board->save();

        return $board;
    }

    public function show($id)
    {
        $board = Board::find($id)->with('tasks')->get()->toArray()[0];
        if( $board ) {
            return $board;
        } else {
            return [];
        }
    }

    public function update($id)
    {
        $board = Board::find($id);

        if( $board ) {
            $board->title = $this->requestData['title'];
            $board->update();

            return $board;
        }

        return null;
    }

    public function destroy($id)
    {
        $board = Board::find($id);
        if( !$board ) {
            return false;
        } 

        //before deleting board we have to delete all related tasks
        Task::where('board_id',$board->id)->delete();

        $board->delete();
        return true;
    }
}
