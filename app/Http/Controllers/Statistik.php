<?php

namespace App\Http\Controllers;

use App\Product;
use App\Puchase;
use App\PuchaseList;
use Illuminate\Http\Request;
use stdClass;

class Statistik extends Controller
{
    //
    public function transaksi(Request $request)
    {

        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        $dataTahun = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $dateList = Puchase::whereYear('created_at', '=', $tahun)->distinct()->get();
        foreach ($dateList as $key => $value) {
            $bulan =  date('m', strtotime($value->created_at));
            $dataTahun[$bulan - 1]++;
        }

        return json_encode([
            'jumlah_transaksi' => $dataTahun,
            'label' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
        ]);
    }

    public function produk(Request $request)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        $products = Product::all();
        //1
        $maxJumlah = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
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
            //2
            if ($maxJumlah[$bulan - 1] < $bulanan[$bulan - 1]) {
                $maxJumlah[$bulan - 1] = $bulanan[$bulan - 1];
            }
        }

        $results = array();
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
        if ($counter > 0) {
            $results['status'] = 200;
        } else {
            $results['results'] = 'null';
            $results['status'] = 404;
        }

        return json_encode($results);
    }

    public function pendapatan(Request $request)
    {
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } else {
            $tahun = date('Y');
        }
        $uangMasukTahun = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $max = 0;
        $maxBulan = 0;
        $dateList = Puchase::whereYear('created_at', '=', $tahun)->distinct()->get();
        foreach ($dateList as $key => $value) {
            $bulan =  date('m', strtotime($value->created_at));
            $uangMasukTahun[$bulan - 1] += $value->grand_total;
            if ($max < $uangMasukTahun[$bulan - 1]) {
                $max = $uangMasukTahun[$bulan - 1];
                $maxBulan = $bulan - 1;
            }
        }

        return json_encode([
            'jumlah_pendapatan' => $uangMasukTahun,
            'label' => $namaBulan,
            'max' => $max,
            'max_bulan' => $namaBulan[$maxBulan]
        ]);
    }
}
