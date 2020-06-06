@extends('layouts.app')

@section('title','Statistik ' . config('app.name','Laravel'))

@section('css')
<link rel="stylesheet" href="{{asset('css/Chart.css')}}">
<script src="{{asset('js/Chart.js')}}"></script>
@endsection


@section('content')

<div class="row my-3">
    <div class="col-md-6 col-12 text-md-left text-center">
        <h2 class="mb-0">Statistik {{config('app.name','Laravel')}}</h3>
            <p class="text-primary"></p>
    </div>

</div>
<div class="row pt-3 justify-content-center">
    <div class="col-md-6 col-11 my-3">
        <div class="bg-white bulat card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Statistik Transaksi</h2>
                </div>
                <div class="col-12">
                    <canvas id="transaksi" height="200"></canvas>
                    <script defer>
                        var ctx = document.getElementById('transaksi');
                        var color = getComputedStyle(document.querySelector('.text-primary')).color;
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                fill : false,
                                data: [
                                    <?php foreach($jumlahTransaksi as $value){
                                        echo $value. ', ';
                                    }?>
                                ]
                                ,
                                backgroundColor: color,
                                borderColor:  color,
                                borderWidth: 1
                            }]
                            },
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-11 my-3">
        <div class="bg-white bulat card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Statistik Pendapatan</h2>
                </div>
                <div class="col-12">
                    <canvas id="pendapatan" height="200"></canvas>
                    <script defer>
                        var ctx = document.getElementById('pendapatan');
                        var color = getComputedStyle(document.querySelector('.text-primary')).color;
                        var pendapatan = new Chart(ctx, {
                            type: 'line',
                            data: {
                            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                            datasets: [{
                                label: 'Pemasukan',
                                fill : false,
                                data: [
                                    <?php foreach($jumlahPendapatan as $value){
                                        echo $value. ', ';
                                    }?>
                                ]
                                ,
                                backgroundColor: color,
                                borderColor:  color,
                                borderWidth: 1
                            }]
                            },
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-11 my-3">
        <div class="bg-white bulat card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Statistik Produk Terlaris</h2>
                </div>
                <div class="col-12">
                    <canvas id="products" height="200"></canvas>
                    <script defer>
                        var ctx = document.getElementById('products');
                        var color = getComputedStyle(document.querySelector('.text-primary')).color;
                        var terlaris = new Chart(ctx, {
                            type: 'line',
                            data: {
                            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                            datasets: [
                                <?php foreach ($products as $key => $value) {?>
                                {
                                        label: '<?= $value->name ?>',
                                        fill:false,
                                        data: [
                                                <?php foreach ($value->bulanan as $key => $val) {
                                                echo $val . ',';
                                                } ?>
                                            ],
                                        backgroundColor: '#'+(0x1000000+(Math.random())*0xffffff).toString(16).substr(1,6),
                                        borderColor:  '#'+(0x1000000+(Math.random())*0xffffff).toString(16).substr(1,6),
                                        borderWidth: 1
                                    },
                                <?php } ?>
                                ]
                            },
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-11 my-3">
        <div class="bg-white bulat card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Statistik Produk Terjual</h2>
                </div>
                <div class="col-12">
                    <canvas id="produkTerjual" height="200"></canvas>
                    <script defer>
                        var ctk = document.getElementById('produkTerjual');
                            var color = getComputedStyle(document.querySelector('.text-primary')).color;
                            var myChart2 = new Chart(ctk, {
                                type: 'line',
                                data: {
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                datasets: [{
                                    label: 'Produk terjual',
                                    fill : false,
                                    data: [
                                        <?php foreach($jumlahProduk as $value){
                                            echo $value. ', ';
                                        }?>
                                    ]
                                    ,
                                    backgroundColor: color,
                                    borderColor:  color,
                                    borderWidth: 1
                                }]
                                },
                            });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
