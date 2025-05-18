<h1>Nový kurz</h1>
<form method="POST" action="{{ route('courses.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Název kurzu">
    <textarea name="description" placeholder="Popis kurzu"></textarea>
    <button type="submit">Uložit</button>
</form>