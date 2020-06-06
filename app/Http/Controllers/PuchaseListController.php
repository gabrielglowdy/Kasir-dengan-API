<?php

namespace App\Http\Controllers;

use App\Product;
use App\Puchase;
use App\PuchaseList;
use Illuminate\Http\Request;

class PuchaseListController extends Controller
{

    //For API
    public function purchaseList(Request $request)
    {
        if (isset($request->idTransaksi)) {
            $id = $request->idTransaksi;
            $products = PuchaseList::where('id_purchase', $id)->get();
            $purchase = Puchase::where('id', $id)->first();
            if ($purchase == null || count($products) == 0) {
                $res = array(
                    'status' => 404,
                    'results' => 'IdTransaksi tidak valid'
                );
            } else {
                // return $products;
                foreach ($products as $key => $value) {
                    $product = Product::where('id', $value->id_product)->first();
                    if ($product == null) {
                        $value->name = '(-deleted product-)';
                    } else {
                        $value->name = $product->name . ' ' . $product->size;
                    }
                    $value->rawPrice = $value->price;
                    $value->price = 'Rp ' . number_format($value->price, 0, ".", ".");
                    $value->rawSubTotal = $value->subtotal;
                    $value->subtotal = 'Rp ' . number_format($value->subtotal, 0, ".", ".");
                }
                $purchase->date = date("d F Y", strtotime($purchase->created_at));
                $purchase->jam = date("H:i:s", strtotime($purchase->created_at));
                $purchase->rawTotal= $purchase->total;
                $purchase->rawKembalian= $purchase->kembalian;
                $purchase->rawGrand_total= $purchase->grand_total;
                $purchase->rawTerbayar= $purchase->terbayar;
                $purchase->total = 'Rp ' . number_format($purchase->total, 0, ".", ".");
                $purchase->kembalian = 'Rp ' . number_format($purchase->kembalian, 0, ".", ".");
                $purchase->grand_total = 'Rp ' . number_format($purchase->grand_total, 0, ".", ".");
                $purchase->terbayar = 'Rp ' . number_format($purchase->terbayar, 0, ".", ".");

                $res = array(
                    'status' => 200,
                    'detail' => $purchase,
                    'products' => $products
                );
            }
        } else {
            $res = array(
                'status' => 404,
                'results' => 'Dibutuhkan IdTransaksi'
            );
        }
        // return json_encode($res);
        return response($res,$res['status']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PuchaseList  $puchaseList
     * @return \Illuminate\Http\Response
     */
    public function show(PuchaseList $puchaseList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PuchaseList  $puchaseList
     * @return \Illuminate\Http\Response
     */
    public function edit(PuchaseList $puchaseList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PuchaseList  $puchaseList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PuchaseList $puchaseList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PuchaseList  $puchaseList
     * @return \Illuminate\Http\Response
     */
    public function destroy(PuchaseList $puchaseList)
    {
        //
    }
}
