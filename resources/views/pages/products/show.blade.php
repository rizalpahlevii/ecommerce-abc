@extends('layouts.app')
@section('content')
<div class="row mt-3">
    <div class="col-md-4 mt-2">
        <img src="{{ $product->getFirstMediaUrl('image') }}" class="img-thumbnail" alt="...">
    </div>
    <div class="col-md-8">
        <h3>
            {{$product->name}}
        </h3>
        <h6>
            {{$product->price}}
        </h6>
        <form action="{{ route('carts.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="btn btn-sm btn-primary">Tambahkan Ke Keranjang</button>
        </form>
    </div>
</div>
@endsection
