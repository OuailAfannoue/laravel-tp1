<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class TaskUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $oldTask;
    public $newTask;

    public function __construct(Task $oldTask, Task $newTask)
    {
        $this->oldTask = $oldTask;
        $this->newTask = $newTask;
    }
}
