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
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Total</th>
                            <th>Kembalian</th>
                            <th>Grand Total</th>
                            <th>Terbayar</th>
                            <th>Kasir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $data)
                        <tr>
                            <td><a href="/transaction/detail/{{$data->id}}">{{$data->id}}</a></td>
                            <td>{{$data->date}}</td>
                            <td>{{$data->day}}</td>
                            <td>{{$data->jam}}</td>
                            <td>{{$data->total}}</td>
                            <td>{{$data->kembalian}}</td>
                            <td>{{$data->grand_total}}</td>
                            <td>{{$data->terbayar}}</td>
                            <td>{{$data->kasir}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
