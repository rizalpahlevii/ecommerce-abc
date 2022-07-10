@extends('layouts.app')
@section('content')
<div class="row mt-3">
    <div class="col-md-12">
        <table class="table table-bordered table-hover table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $subtotal = 0;
                @endphp
                @foreach ($carts as $cart)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cart->product->name }}</td>
                    <td>{{ $cart->quantity }}</td>
                    <td>{{ $cart->product->price }}</td>
                    <td>{{ $cart->quantity * $cart->product->price }}</td>
                    @php
                    $subtotal += ($cart->quantity * $cart->product->price);
                    @endphp
                    <th>
                        <a href="#" class="btn btn-light btn-sm btn-increment" data-loop="{{ $loop->iteration }}"
                            title="Tambah"><i class="fa fa-trash"></i>
                            +</a>
                        <form action="{{ route('carts.increment',$cart->id) }}" method="POST"
                            class="form-increment-{{ $loop->iteration }}">
                            @csrf
                            @method('POST')

                        </form>
                        <a href="#" class="btn btn-light btn-sm btn-decrement" data-loop="{{ $loop->iteration }}"
                            title="Kuran"><i class="fa fa-trash"></i>
                            -</a>
                        <form action="{{ route('carts.decrement',$cart->id) }}" method="POST"
                            class="form-decrement-{{ $loop->iteration }}">
                            @csrf
                            @method('POST')

                        </form>

                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-loop="{{ $loop->iteration }}"
                            title="Hapus"><i class="fa fa-trash"></i>
                            Hapus</a>
                        <form action="{{ route('carts.delete',$cart->id) }}" method="POST"
                            class="form-delete-{{ $loop->iteration }}">
                            @csrf
                            @method('DELETE')

                        </form>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if (count($carts))
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('carts.checkout') }}" class="btn btn-sm btn-primary float-right">Checkout</a>
    </div>

</div>
@endif
@endsection


@push('script')
<script>
    $(document).ready(function(){
        $('.btn-delete').click(function (e) {

                loop = $(this).data('loop');
                $(`.form-delete-${loop}`).submit();
           });
        $('.btn-increment').click(function (e) {

            loop = $(this).data('loop');
            $(`.form-increment-${loop}`).submit();

        });
        $('.btn-decrement').click(function (e) {
                loop = $(this).data('loop');
                $(`.form-decrement-${loop}`).submit();
        });
    });
</script>
@endpush
