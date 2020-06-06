@extends('layouts.app')

@section('title', 'Change')
@section('content')
    <div class="bg-white card-body">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h5>Kembalian</h5>
            <h6>{{$kembali}}</h6>
        </div>
        <div class="col-10 text-center mt-3">
            <a href="/order/new" class="btn bulat btn-primary py-2 w-50">Transaksi lagi</a>
        </div>
    </div>
    </div>
@endsection
