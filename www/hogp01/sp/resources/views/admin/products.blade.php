@extends('app')

@section('title', 'Produkty')
@section('content')

<script>
  function openModal(url) {
    document.getElementById('modal_iframe').src = `{{ url()->current() }}/${url}`;
    document.getElementById('modal').style.display = 'block';
  }
  function closeModal() {
    document.getElementById('modal_iframe').src = "";
    document.getElementById('modal').style.display = 'none';
  }
</script>
<div class="modal" id="modal">
  <button class="close" onclick="closeModal()"><i class="bi bi-x-circle"></i></button>
  <iframe id="modal_iframe" src="">

  </iframe>
</div>
<div class="product-editor">
  
  <div class="wrapper">
    <h3>Produkty</h3>
    <button class="button success"  onclick="openModal('new')">Vytvoriť produkt</button>
    <div class="accordion">
      @foreach($products as $product)
      <div class="item" onclick="openModal('detail/{{ $product->id }}')">
        <div class="header">
          <div class="left">
            <p>{{ $product->name }}</p>
          </div>
          <div class="right">
            <p>{{ $product->price }} Kč</p>
            <p>{{ $product->updated_at }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

@endsection