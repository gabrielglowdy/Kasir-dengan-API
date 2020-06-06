@extends('layouts.app-full')

@section('title', 'Checkout')
@section('content')
<form action="/order/pay" method="post" id="form-checkout">
    @csrf
    <div id="order-list">
        <input type="hidden" id="counter" name="counter" value="{{$counter}}">
    </div>
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h3 class="mb-3">Checkout</h3>
        </div>
        <div class="col-md-7 col-11">
            <div class="bulat bg-white card-body pb-1">
                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>QTY</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $key => $value)
                        <tr>
                            <td>{{$key}}</td>
                            <input type="hidden" name="order-{{$key}}" value="{{$value->id}}">
                            <input type="hidden" name="jumlah-{{$key}}" value="{{$value->jumlah}}">
                            <td>{{$value->name}}</td>
                            <td>{{$value->price}}</td>
                            <td>{{$value->jumlah}}</td>
                            <td>{{$value->subtotal}}</td>
                        </tr>
                        @endforeach
                        @if(config('app.ppn',10) > 0)
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <td colspan="3">{{$total}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">PPN ({{$ppn}}%)</th>
                            <td colspan="3">{{$ppnTotal}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Total + PPN ({{$ppn}}%)</th>
                            <td colspan="3">{{$ppn_total}}</td>
                        </tr>
                        @endif
                        @if(config('app.pembulatan', true))
                        <tr>
                            <th colspan="3" class="text-right">Pembulatan</th>
                            <td colspan="3">{{$pembulatan}}</td>
                        </tr>
                        @endif
                        <tr>
                            <th colspan="3" class="text-right">Total yang harus dibayar</th>
                            <td colspan="3">{{$grandTotal}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right pt-3">Dibayar</th>
                            <td colspan="3"><input type="number" name="bayar" id="bayar" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-11">
            <div class="bulat bg-white card-body">
                <div class="row">
                    @for($i=1; $i<=9; $i++) <div class="col-4 px-2 my-2">
                        <div class="bg-abu bulat card-body text-center"
                            onclick="document.getElementById('bayar').value += '{{$i}}'">
                            <h6 class="mb-0">{{$i}}</h6>
                        </div>
                </div>
                @endfor
                <div class="col-4 px-2 my-2">
                    <div class="bg-abu bulat card-body text-center"
                        onclick="document.getElementById('bayar').value = document.getElementById('bayar').value.substring(0, document.getElementById('bayar').value.length -1);">
                        <h6 class="mb-0 material-icons">backspace</h6>
                    </div>
                </div>
                <div class="col-4 px-2 my-2">
                    <div class="bg-abu bulat card-body text-center" onclick="zero(1)">
                        <h6 class="mb-2">0</h6>
                    </div>
                </div>
                <div class="col-4 px-2 my-2">
                    <div class="bg-abu bulat card-body text-center"
                        onclick="document.getElementById('bayar').value = '' ">
                        <h6 class="mb-0 material-icons">settings_backup_restore</h6>
                    </div>
                </div>
                <div class="col-4 px-2 my-2">
                    <div class="bg-abu bulat card-body text-center" onclick="zero(2)">
                        <h6 class="mb-0">00</h6>
                    </div>
                </div>
                <div class="col-4 px-2 my-2">
                    <div class="bg-abu bulat card-body text-center"
                        onclick="document.getElementById('bayar').value = '{{$rawGrandTotal}}'">
                        <h6 class="mb-0">PAS</h6>
                    </div>
                </div>
                <div class="col-4 px-2 my-2">
                    <div class="bg-abu bulat card-body text-center" onclick="zero(3)">
                        <h6 class="mb-0">000</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <a href="javascript:{}" onclick="submit()" class="btn bulat mt-3 py-2 btn-success w-100">BAYAR</a>
        </div>
    </div>
    </div>


    @section('js')
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/swall.js')}}"></script>
    <script>
        function zero(num) {
            var bayar = document.getElementById('bayar');
            if (bayar.value == '' || bayar.value == null || bayar.value == 0) {

            }else{
                var stringX = '';
                for (let index = 0; index < num; index++) {
                    stringX += '0';
                }

                bayar.value += stringX;
            }
        }
        function submit() {
            var bayar = document.getElementById('bayar');
            var total = <?php echo $rawGrandTotal; ?>;

            if (bayar.value < total) {
                swal.fire({
                    title : 'Uang yang dibayarkan belum cukup',
                    icon : 'error'
                });
            }else{
                document.getElementById('form-checkout').submit();
            }
        }
    </script>
    @endsection
</form>
@endsection
