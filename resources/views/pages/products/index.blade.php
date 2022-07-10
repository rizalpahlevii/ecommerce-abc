@extends('layouts.app')
@section('content')
<div class="row mt-3">
    @foreach ($products as $product)
    <div class="col-md-4 mt-2">
        <div class="card" style="width: 18rem;">

            <img src="{{ $product->getFirstMediaUrl('image') }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}e</h5>
                <p class="card-text">
                    {{ $product->description }}
                </p>
                <a href="{{ route('products.show',$product->id) }}" class="btn btn-primary">Detail</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
