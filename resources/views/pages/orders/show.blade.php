@extends('layouts.app')
@section('content')
<div class="row mt-3">
    <div class="col-md-12">
        <table class="table table-bordered table-hover table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah Beli</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->quantity * $item->price }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table">
            <tr>
                <th>Subtotal</th>
                <th>:</th>
                <th>{{ $order->total }}</th>
            </tr>
            <tr>
                <th>Ongkir</th>
                <th>:</th>
                <th>{{ $order->shipping_cost }}</th>
            </tr>
            <tr>
                <th>Grandtotal</th>
                <th>:</th>
                <th>{{ $order->grandtotal }}</th>
            </tr>
        </table>
    </div>
</div>

@endsection
