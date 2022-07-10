@extends('layouts.app')
@section('content')
<div class="row mt-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Cek Ongkir</h3>
            </div>
            <div class="card-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="form" method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="province_id">Kota Asal</label>
                        <select class="form-control" id="province_id" name="province_id" required>
                            <option disabled selected>Pilih Provinsi</option>
                            @foreach ($provinces->results as $province)
                            <option value="{{ $province->province_id }}" data-name="{{ $province->province }}">{{
                                $province->province }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="province_name" id="province_name">
                    <input type="hidden" name="city_name" id="city_name">
                    <div class="form-group">
                        <label for="city_id">Kota Tujuan</label>
                        <select class="form-control" id="city_id" name="city_id" disabled>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="courier_code">Kurir</label>
                        <select class="form-control" id="courier_code" name="courier_code" required>
                            <option value="jne">JNE</option>
                            <option value="tiki">TIKI</option>
                            <option value="pos">POS INDONESIA</option>
                        </select>
                    </div>
                    <button class="btn btn-sm btn-primary mt-2 btn-ship" type="button">Cek Ongkir</button>
                    <div class="form-group">
                        <label for="service">Layanan</label>
                        <select class="form-control" id="service">

                        </select>
                    </div>
                    <input type="hidden" name="service_code" id="service_code" value="">
                    <input type="hidden" name="cost_value" id="cost_value" value="">
                    <input type="hidden" name="cost_etd" id="cost_etd" value="">
                    <input type="hidden" name="cost_note" id="cost_note" value="">
                    <button type="submit" class="btn btn-primary">Checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('.btn-ship').click(function(){
            url = `{{ route('areas.cost') }}`;
            $.ajax({
                url : url,
                method:'post',
                dataType:'json',
                data:{
                    city_id : $('#city_id').val(),
                    courier_code : $('#courier_code').val(),
                },
                success:function(response){
                    data_option='';
                    response.results.forEach((item,i)=>{

                        item.costs.forEach((cost,j)=>{
                            data_option+= `<option
                                data-service="${cost.service}"
                                data-value="${cost.cost[0].value}"
                                data-etd="${cost.cost[0].etd}"
                                data-note="${cost.cost[0].note}"
                            >${cost.service} (${cost.description}) - ${cost.cost[0].value} (${cost.cost[0].etd} Hari)</option>`;
                        })
                    });
                    $('#service').html(data_option);
                }
            })
        });
        $('#service').change(function(){
            $('#service_code').val($(this).find(':selected').data('service'));
            $('#cost_value').val($(this).find(':selected').data('value'));
            $('#cost_etd').val($(this).find(':selected').data('etd'));
            $('#cost_note').val($(this).find(':selected').data('note'));
        });
        $('#city_id').change(function(){
            $('#city_name').val($(this).find(':selected').data('name'));
        });
        $('#province_id').change(function(){
            $('#province_name').val($(this).find(':selected').data('name'));
            provinceId = $(this).val();
            url = `{{ route('areas.cities',':province') }}`;
            url = url.replace(':province',provinceId);
            $.ajax({
                url : url,
                method:'get',
                success:function(response){
                    var data_option = "";
                    response = JSON.parse(response);
                    cities = response.results;
                    cities.forEach((item,i)=>{
                        data_option += `<option value="${item.city_id}" data-name="${item.type} ${item.city_name}">${item.type} ${item.city_name}</option>`;
                    });
                    $('#city_id').removeAttr('disabled');
                    $('#city_id').html(data_option);
                }
            })
        });
    });
</script>
@endpush
