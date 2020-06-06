@extends('layouts.app')

@section('content')

<div class="row my-3">
    <div class="col-6">
        <h2 class="mb-0">Daftar Kategori</h3>
    </div>
    <div class="col-6 text-right">
        <a href="/category/new" class="bulat bg-primary text-light p-3 ">Tambah Kategori baru</a>
    </div>
</div>
<div class="row pt-3">
    <div class="col-12">
        <div class="bg-white bulat card-body">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $value)
                    <tr>
                        <td>{{$value->id}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->total_produk}}</td>
                        <td>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/category/edit/{{$value->id}}" class="btn btn-warning w-100">Edit</a>
                                </div>
                                <div class="col-md-6">
                                    <form action="/category/delete/{{$value->id}}" method="post">
                                    @csrf
                                    <input type="submit" value="Delete" class="btn btn-danger w-100">
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
