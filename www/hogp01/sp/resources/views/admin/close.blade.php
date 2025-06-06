@extends('iframe')

@section('title', 'Produkty')
@section('content')
<script>
    window.top.location.href = "{{ route('admin.products.index')}}";
</script>
@endsection