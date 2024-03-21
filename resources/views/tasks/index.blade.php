<!-- resources/views/tasks/index.blade.php -->

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Date d'échéance</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($tasks->isEmpty())
            <tr>
                <td colspan="4">Aucune tâche n'a été trouvée.</td>
            </tr>
        @else
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->due_date }}</td>
                <td>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        <a href="{{ route('tasks.edit', $task->id) }}">Modifier</a>
                        <button type="submit">Supprimer</button>
                        @method('DELETE')
                        @csrf
                    </form>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $tasks->links() }}

<!-- Bouton pour ajouter une nouvelle tâche -->
<a href="{{ route('tasks.create') }}">Ajouter une tâche</a>
