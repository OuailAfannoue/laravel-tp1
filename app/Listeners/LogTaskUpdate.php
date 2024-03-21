<?php

namespace App\Listeners;

use App\Events\TaskUpdated;

class LogTaskUpdate
{
    public function handle(TaskUpdated $event)
    {
        $oldTask = $event->oldTask;
        $newTask = $event->newTask;

        // Logique pour enregistrer l'historique des modifications
        // ...
    }
}
