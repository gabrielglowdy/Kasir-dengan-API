@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('content')
<form action="/category/new" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <h2 class="mb-0">Tambah Kategori</h3>
        </div>
        <div class="col-12">
        <div class="bg-white bulat">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">
                        Nama Kategori :
                    </label>
                    <input type="text" name="nama_kategori" class="form-control" placeholder="">
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
