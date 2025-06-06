<h1>Nová lekce</h1>
<form method="POST" action="{{ route('lessons.store') }}">
    @csrf
    <input type="number" name="course_id" placeholder="ID kurzu">
    <input type="text" name="title" placeholder="Název lekce">
    <textarea name="content" placeholder="Obsah lekce"></textarea>
    <button type="submit">Uložit</button>
</form>
