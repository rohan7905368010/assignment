<?php

namespace App\BusinessLayer;

use App\Board;
use App\Task;

class TaskLogic
{
    public $requestData;
    public function __construct($_request)
    {
        $this->requestData = $_request;
    }

    public function index()
    {
        $task = Task::where('board_id',$this->requestData['board_id'])->get()->toArray();
        return $task;
    }

    public function store()
    {
        //this is for checking if user has made that task or not if not
        //we will return from here without performing further operations
        $hasUserCreatedtask = $this->CheckCreatorOftask($this->requestData['board_id']);

        if ($hasUserCreatedtask) {
            $task = new Task;
            $task->title = $this->requestData['title'];
            $task->description = $this->requestData['description'];
            $task->board_id = $this->requestData['board_id'];

            $task->save();

            return $task;
        }
    }

    public function show($id)
    {
        $task = task::find($id);
        if ($task) {
            return $task;
        } else {
            return [];
        }
    }

    public function update($id)
    {
        $task = task::find($id);
        if( !$task ) {
            return null;
        }

        //checking user authorization for task 
        $hasUserCreatedtask = $this->CheckCreatorOftask($task->board_id);
        if( !$hasUserCreatedtask ) {
            return null;
        }

        $task->title = $this->requestData['title'];
        $task->description = $this->requestData['description'];
        $task->update();

        return $task;
    }

    public function destroy($id)
    {
        $task = task::find($id);
        if( !$task ) {
            return false;
        }

        //checking user authorization for task 
        $hasUserCreatedtask = $this->CheckCreatorOftask($task->board_id);
        if( !$hasUserCreatedtask ) {
            return false;
        }

        $task->delete();
        return true;
    }

    //private functions
    private function CheckCreatorOftask($_boardId)
    {
        $board = Board::find($_boardId);

        if ( $board ) {
            if (auth()->user()['id'] === $board->user_id) {
                return true;
            }
        }

        return false;
    }
}
