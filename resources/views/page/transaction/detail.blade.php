@extends('layouts.app')

@section('title', 'Daftar Transaksi')
@section('content')
<div class="row">
    <div class="col-6 mb-3">
        <h2 class="mb-0">Daftar Transaksi</h3>
    </div>
    <div class="col-12">
        <div class="bg-white bulat">
            <div class="card-body">
                <table class="table table-bordered">
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
                        @foreach($products as $key => $data)
                        <tr>

                            <td>{{$key + 1}}</td>
                            <td>{{$data->name}} {{$data->size}}</td>
                            <td>{{$data->price}}</td>
                            <td>{{$data->jumlah}}</td>
                            <td>{{$data->subtotal}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3" class="text-right">Total + PPN ({{$total->ppn}}%)</th>
                            <td colspan="2">{{$total->total}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Pembulatan</th>
                            <td colspan="2">{{$total->pembulatan}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Grand Total</th>
                            <td colspan="2">{{$total->grand_total}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Terbayar</th>
                            <td colspan="2">{{$total->terbayar}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Kembalian</th>
                            <td colspan="2">{{$total->kembalian}}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Kasir</th>
                            <td colspan="2">{{$total->kasir}} ({{$total->date}} {{$total->jam}})</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
