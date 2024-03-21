<form action="{{ route('tasks.store') }}" method="post">
    @csrf
    <div>
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
        <label for="due_date">Date d'échéance :</label>
        <input type="date" id="due_date" name="due_date" required>
    </div>
    <button type="submit">Ajouter</button>
</form>
