<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\Puchase;
use App\PuchaseList;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as IlluminateRoute;
use stdClass;
use Symfony\Component\Routing\Annotation\Route as SymfonyRoute;

class Pages extends Controller
{



    public function statistik()
    {
        $tahun = date('Y');
        $products = Product::all();
        foreach ($products as $key => $value) {
            $jumlah = PuchaseList::where('id_product', $value->id)->whereYear('created_at', '=', $tahun)->distinct()->get();
            $counter = 0;
            $bulanan = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            foreach ($jumlah as $key => $val) {
                $counter += $val->jumlah;
                $bulan =  date('m', strtotime($val->created_at));
                $bulanan[$bulan - 1] += $val->jumlah;
            }
            $value->bulanan = $bulanan;
            $value->jumlah = $counter;
            // if ($value->jumlah > 0) {
            // echo $value;
            // }
        }
        // return;
        $dataTahun = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $produkTerjualTahun = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $uangMasukTahun = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $dateList = Puchase::whereYear('created_at', '=', $tahun)->distinct()->get();
        foreach ($dateList as $key => $value) {
            $bulan =  date('m', strtotime($value->created_at));
            $uangMasukTahun[$bulan - 1] += $value->grand_total;
            $dataTahun[$bulan - 1]++;
            $productsX = PuchaseList::where('id_purchase',$value->id)->get();

            foreach ($productsX as $perProduct) {
                $produkTerjualTahun[$bulan-1] += $perProduct->jumlah;
            }
        }

        //terlaris
        $products = Product::all();
        //1
        $maxJumlah = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($products as $key => $value) {
            $jumlah = PuchaseList::where('id_product', $value->id)->whereYear('created_at', '=', $tahun)->distinct()->get();
            $counter = 0;
            $bulanan = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $bulan = date('m');
            foreach ($jumlah as $key => $val) {
                $counter += $val->jumlah;
                $bulan =  date('m', strtotime($val->created_at));
                $bulanan[$bulan - 1] += $val->jumlah;
            }
            $value->bulanan = $bulanan;
            $value->jumlah = $counter;
            //2
            if ($maxJumlah[$bulan - 1] < $bulanan[$bulan - 1]) {
                $maxJumlah[$bulan - 1] = $bulanan[$bulan - 1];
            }
        }

        $results = array();
        $results['results'] = array();
        $counter = 0;
        foreach ($products as $key => $value) {
            //Kenapa MaxJumlah/2 ? karena kita mencari produk yang diatas rata rata
            $find = false;
            foreach ($value->bulanan as $key => $val) {
                if ($val  > ($maxJumlah[$key] / 2) && $val > 0) {
                    $find = true;
                }
            }
            if ($find) {
                $results['results'][$counter] = $value;
                $counter++;
            }
        }
        return view('page/statistic/all')->with([
            'jumlahTransaksi' => $dataTahun,
            'jumlahProduk' => $produkTerjualTahun,
            'jumlahPendapatan' => $uangMasukTahun,
            'products' => $results['results'],
        ]);
    }

    public function apiList()
    {
        // Artisan::call('route:list --path=api');

        // return Artisan::output();
        // return Artisan::call('route:list --path=api');
        $routes = [];
        $exceptional = array('api/user', 'api-list');

        $listApi = array();
        $counter = 0;
        foreach (Route::getRoutes()->getIterator() as $route) {
            if (strpos($route->uri, 'api') !== false) {
                $aman = true;
                for ($i = 0; $i < count($exceptional); $i++) {
                    // echo $exceptional[$i] . '<br>';
                    if ($route->uri == $exceptional[$i]) {
                        $aman = false;
                        break;
                    }
                }
                if ($aman) {
                    $listApi[$counter] = new stdClass();
                    $listApi[$counter]->method = $route->methods[0];
                    $listApi[$counter]->url = $route->uri;

                    // echo ' | ' . $route->methods[0] . ' | <a href="' . $route->uri . '">' . $route->uri .  "</a> <br>";
                    $counter++;
                }
                // $routes[] = $route->uri;
            }
        }
        return view('page/api/list')->with(['lists' => $listApi]);
        // return json_encode(SymfonyRoute::getRoutes());
        // return $routes;
    }

    public function history()
    {
        $products = Puchase::orderBy('created_at', 'desc')->get();
        foreach ($products as $key => $value) {
            $value->date = date("d F Y", strtotime($value->created_at));
            $value->day = date("l", strtotime($value->created_at));
            $value->jam = date("H:i:s", strtotime($value->created_at));
            $value->total = 'Rp ' . number_format($value->total, 0, ".", ".");
            $value->kembalian = 'Rp ' . number_format($value->kembalian, 0, ".", ".");
            $value->grand_total = 'Rp ' . number_format($value->grand_total, 0, ".", ".");
            $value->terbayar = 'Rp ' . number_format($value->terbayar, 0, ".", ".");
        }
        return view('page/transaction/list')->with(['products' => $products]);
    }

    public function historyPurchase($id)
    {
        $products = PuchaseList::where('id_purchase', $id)->get();
        $purchase = Puchase::where('id', $id)->first();
        if ($purchase == null || count($products) == 0) {
            return redirect('/transaction/list');
        }
        foreach ($products as $key => $value) {
            $product = Product::where('id', $value->id_product)->first();
            if ($product == null) {
                $value->name = '(-deleted product-)';
            } else {
                $value->name = $product->name . ' ' . $product->size;
            }
            $value->price = 'Rp ' . number_format($value->price, 0, ".", ".");
            $value->subtotal = 'Rp ' . number_format($value->subtotal, 0, ".", ".");
        }
        $purchase->date = date("d F Y", strtotime($purchase->created_at));
        $purchase->jam = date("H:i:s", strtotime($purchase->created_at));
        $purchase->total = 'Rp ' . number_format($purchase->total, 0, ".", ".");
        $purchase->kembalian = 'Rp ' . number_format($purchase->kembalian, 0, ".", ".");
        $purchase->grand_total = 'Rp ' . number_format($purchase->grand_total, 0, ".", ".");
        $purchase->terbayar = 'Rp ' . number_format($purchase->terbayar, 0, ".", ".");
        $purchase->pembulatan = 'Rp ' . number_format($purchase->pembulatan, 0, ".", ".");


        return view('page/transaction/detail')->with(['products' => $products, 'total' => $purchase]);
    }
    //

    public function home()
    {
        if (Auth::check()) {
            return view('page/home');
        } else {
            return redirect(route('login'));
        }
    }
}
