@extends('layouts.app')
@section('content')
<div class="row mt-3">
    <div class="col-md-12">
        <table class="table table-bordered table-hover table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Ongkir</th>
                    <th>Grantotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->number }}</td>
                    <td>{{ $order->date }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->shipping_cost }}</td>
                    <td>{{ $order->grandtotal }}</td>
                    <td>
                        <a href="{{ route('orders.show',$order->id) }}" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
