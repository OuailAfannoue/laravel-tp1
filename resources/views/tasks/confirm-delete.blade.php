<p>Êtes-vous sûr de vouloir supprimer la tâche "{{ $task->title }}" ?</p>

<form action="{{ route('tasks.destroy', $task->id) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit">Confirmer la suppression</button>
</form>

<a href="{{ route('tasks.index') }}">Annuler</a>
