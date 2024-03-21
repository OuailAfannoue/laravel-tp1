<form action="{{ route('tasks.update', $task->id) }}" method="post">
    @csrf
    @method('PUT')
    <div>
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" value="{{ $task->title }}" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description">{{ $task->description }}</textarea>
    </div>
    <div>
        <label for="due_date">Date d'échéance :</label>
        <input type="date" id="due_date" name="due_date" value="{{ $task->due_date }}" required>
    </div>
    <button type="submit">Modifier</button>
</form>
