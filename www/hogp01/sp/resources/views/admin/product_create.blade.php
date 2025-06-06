@extends('iframe')

@section('title', 'Produkty')
@section('content')

<form class="form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-hrbox">
    <div class="field">
      <label for="name">Jméno</label>
      <input id="name" name="name" value="{{ old('name') }}" type="text" required>
    </div>
    <div class="spacer"></div>
    <div class="field">
      <label for="price">Cena</label>
      <input id="price" name="price" value="{{ old('price') }}" type="text" required>
    </div>
    <div class="spacer"></div>
    <div class="field">
      <label for="stock">Počet</label>
      <input id="stock" name="stock" value="{{ old('stock') }}" type="text" required>
    </div>
  </div>
  
  <div class="field">
    <label for="category">Kategorie</label>
    <select id="category" name="category_id" required>
      <option value="">Vyberte kategorii</option>
      <!-- Muži -->
      <option value="4">Muži – Trička</option>
      <option value="5">Muži – Košile</option>
      <option value="6">Muži – Kalhoty</option>
      <option value="7">Muži – Bundy</option>
      <option value="8">Muži – Boty</option>
      <option value="9">Muži – Mikiny</option>
      <option value="10">Muži – Svetry</option>
      <option value="11">Muži – Doplňky</option>
      
      <!-- Ženy -->
      <option value="12">Ženy – Trička</option>
      <option value="13">Ženy – Košile</option>
      <option value="14">Ženy – Kalhoty</option>
      <option value="15">Ženy – Bundy</option>
      <option value="16">Ženy – Boty</option>
      <option value="17">Ženy – Mikiny</option>
      <option value="18">Ženy – Svetry</option>
      <option value="19">Ženy – Doplňky</option>
      <option value="20">Ženy – Šaty</option>
      <option value="21">Ženy – Sukně</option>
    </select>
  </div>
  
  <div class="field">
    <label for="description">Popis</label>
    <input id="description" name="description" value="{{ old('description') }}" type="text">
  </div>
  
  <div class="field">
    <label for="size">Velikost</label>
    <select id="size" name="size">
      <option value="">Všechny</option>
      <option value="XS">XS</option>
      <option value="S">S</option>
      <option value="M">M</option>
      <option value="L">L</option>
      <option value="XL">XL</option>
      <option value="XXL">XXL</option>
    </select>
  </div>
  
  <div class="field">
    <label for="color">Barva</label>
    <select id="color" name="color">
      <option value="">Všechny</option>
      <option value="red">🔴 Červená</option>
      <option value="blue">🔵 Modrá</option>
      <option value="green">🟢 Zelená</option>
      <option value="yellow">🟡 Žlutá</option>
      <option value="black">⚫ Černá</option>
      <option value="white">⚪ Bílá</option>
      <option value="purple">🟣 Fialová</option>
      <option value="orange">🟠 Oranžová</option>
    </select>
  </div>
  
  <div class="field">
    <label for="thumbnail">Thumbnail</label>
    <input type="file" name="thumbnail" accept="image/*" required>
  </div>
  
  <div class="field">
    <label for="images[]">Obrázky (max 4)</label>
    <input type="file" name="images[]" multiple accept="image/*" required>
  </div>
  
  <button type="submit">Vytvoriť</button>
</form>

