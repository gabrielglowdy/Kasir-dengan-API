@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('content')
<form action="/category/edit/{{$product->id}}" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <h2 class="mb-0">Edit Kategori</h3>
        </div>
        <div class="col-12">
        <div class="bg-white bulat">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">
                        Nama Kategori :
                    </label>
                    <input type="text" name="nama_kategori" class="form-control" placeholder="" value="{{$product->name}}">
                </div>
                <div class="form-group">
                    <input type="submit" value="Update" class="btn btn-warning">
                </div>
            </div>
        </div>
        </div>
    </div>
</form>
@endsection
