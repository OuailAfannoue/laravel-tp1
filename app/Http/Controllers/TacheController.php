<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use App\Events\TaskUpdated;

class TacheController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $sortBy = $request->query('sort_by');
        $search = $request->query('search');

        // Valider les données saisies dans le formulaire de recherche
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255',
        ]);

        // Rediriger en arrière si la validation échoue
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Récupérer toutes les tâches avec pagination
        $tasksQuery = Task::query();

        // Filtrer les tâches par statut si un statut est fourni
        if ($status) {
            $tasksQuery->where('status', $status);
        }

        // Trier les tâches par date d'échéance ou par ordre alphabétique
        if ($sortBy === 'due_date') {
            $tasksQuery->orderBy('due_date');
        } elseif ($sortBy === 'title') {
            $tasksQuery->orderBy('title');
        }

        // Rechercher les tâches par titre ou par description si une recherche est effectuée
        if ($search) {
            $tasksQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $tasks = $tasksQuery->paginate(10);

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tasks.create')
                ->withErrors($validator)
                ->withInput();
        }

        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->due_date = $request->input('due_date');
        $task->save();

        return redirect()->route('tasks.index');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tasks.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $oldTask = Task::findOrFail($id);
        $oldTaskAttributes = $oldTask->getAttributes();

        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->due_date = $request->input('due_date');
        $task->save();

        // Triggering TaskUpdated event
        event(new TaskUpdated($oldTask, $task));

        return redirect()->route('tasks.index');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index');
    }

    public function complete(Task $task)
    {
        $task->status = 'completed';
        $task->save();

        return redirect()->back()->with('success', 'La tâche a été marquée comme terminée.');
    }
}
