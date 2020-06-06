<div class="card-body bg-white" style="height:99vh; width:180pt;">
    <div class="row mb-2">
        <div class="col-12 text-center">
            <a href="/order/new" class="">
                <div class="bulat card-body py-3 shadow-sm">
                    <div class="row align-item-content px-2">
                        <div class="col-3 align-item-content px-0 text-center">
                            <img src="{{asset('img/create.png')}}" alt="" srcset="" style="width:24px; object-fit:scale-down;">
                        </div>
                        <div class="col-9 align-item-content pt-1">
                            <h6 class="mb-0">Mulai Transaksi</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col-12
        @if(explode('/',Request::path())[0] == 'category')
        font-weight-bold
        @endif">
            <a href="/category/list">Kategori</a>
        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col-12
        @if(explode('/',Request::path())[0] == 'product')
        font-weight-bold
        @endif
        ">
            <a href="/product/list">Produk</a>
        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col-12
        @if(explode('/',Request::path())[0] == 'transaction')
        font-weight-bold
        @endif">
            <a href="/transaction/list">Daftar Transaksi</a>
            <!-- <a href="/transaction/list">Daftar Transaksi</a> -->

        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col-12
        @if(explode('/',Request::path())[0] == 'statistic')
        font-weight-bold
        @endif">
            <a href="/statistic">Statistik {{config('app.name', 'laravel')}}</a>

        </div>
    </div>
</div>
