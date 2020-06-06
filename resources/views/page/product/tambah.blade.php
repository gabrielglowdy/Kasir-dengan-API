@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('content')
<form action="/product/new" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <h2 class="mb-0">Tambah Produk</h3>
        </div>
        <div class="col-12">
        <div class="bg-white bulat">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_produk">
                        Nama Produk :
                    </label>
                    <input required type="text" name="nama_produk" class="form-control" placeholder="ex: Produk A">
                </div>
                <div class="form-group">
                    <label for="desc_produk">
                        Deskripsi Produk :
                    </label>
                    <textarea required name="desc_produk" id="desc_produk" rows="5" class="form-control" placeholder="ex: Produk ini untuk ... "></textarea>
                </div>
                <div class="form-group">
                    <label for="size_produk">
                        Ukuran Produk :
                    </label>
                    <input required type="text" name="ukuran_produk" class="form-control" placeholder="ex: 36gr">
                </div>
                <div class="form-group">
                    <label for="size_produk">
                        Kategori Produk :
                    </label>
                    <select name="kategori_produk" id="" class="form-control">
                        @foreach($category as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                    <!-- <input type="text" name="size_produk" class="form-control" placeholder=""> -->
                </div>
                <div class="form-group">
                    <label for="harga_produk">
                        Harga Produk :
                    </label>
                    <input required type="number" name="harga_produk" class="form-control" placeholder="ex: 9000">
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </div>
        </div>
    </div>
</form>
@endsection
