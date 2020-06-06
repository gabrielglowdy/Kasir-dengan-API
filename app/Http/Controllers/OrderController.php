<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Product;
use App\Puchase;
use App\PuchaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $ppn = 10;
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

    public function list(Request $request)
    {
        /*
        Daftar Param
        id => if exist show order with id else show all
        */

        // $res = new array();
        if (isset($request->id)) {
            $list =  Puchase::where('id', $request->id)->first();
            if ($list == null) {
                $res = array([
                    'status' => 404,
                    'results' => 'null'
                ]);
            }else{
                $res = array([
                    'status' => 200,
                    'results' => $list
                ]);
            }
            return $res[0];
        } else {
            $list = Puchase::all();
            $res = array([
                'status' => 200,
                'results' => $list
            ]);
            return $res[0];
        }
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

    public function newOrder()
    {
        $ca = Category::all();
        // echo $r->name;
        $ppn = $this->ppn;
        return view('page/order/new')->with(['categories' => $ca, 'ppn' => $ppn]);
    }

    public function pay(Request $request)
    {

        $lists = array();
        $total = 0;
        $ppn = $this->ppn;
        for ($i = 1; $i <= $request->counter; $i++) {
            $order = 'order-' . $i;
            $input = 'jumlah-' . $i;
            // echo 'find : ' .  $request->$order;
            $lists[$i] = Product::where('id', $request->$order)->first();

            $lists[$i]->jumlah = $request->$input;
            // $lists[$i]->duration = $request->$duration;
            $lists[$i]->subtotal = $request->$input * $lists[$i]->price;

            $total += $lists[$i]->subtotal;
            $lists[$i]->subtotal = 'Rp ' . number_format($lists[$i]->subtotal, 0, ".", ".");
            $lists[$i]->rawPrice = $lists[$i]->price;

            $lists[$i]->price = 'Rp ' . number_format($lists[$i]->price, 0, ".", ".");
        }

        // return $request;
        $jumlah_ppn = ($ppn / 100) * $total;
        if ($jumlah_ppn + $total > 1000 / 2) {
            $bulat = ceil((($jumlah_ppn + $total) / 1000) * 2) / 2 * 1000 - ($jumlah_ppn + $total);
        } else {
            $bulat = 0;
        }
        $grandTotal = $jumlah_ppn + $total + $bulat;

        $purchase = new Puchase();
        $purchase->grand_total = $grandTotal;
        $purchase->ppn = $ppn;
        $purchase->pembulatan = $bulat;
        $purchase->total = $jumlah_ppn + $total;
        $purchase->terbayar = $request->bayar;
        $purchase->kembalian = $request->bayar - $grandTotal;
        $purchase->kasir = Auth::user()->name;

        $save = $purchase->save();

        echo $purchase->id;

        foreach ($lists as $key => $value) {
            $product = new PuchaseList();
            $product->id_purchase = $purchase->id;
            $product->id_product = $value->id;
            $product->price = $value->rawPrice;
            $product->jumlah = $value->jumlah;
            // $product->duration = $value->duration;
            $product->subtotal = $value->rawPrice * $value->jumlah;

            $product->save();
            // $price
        }

        // echo $grandTotal . '->' . $request->bayar;
        $kembalian = 'Rp ' . number_format($request->bayar - $grandTotal, 0, ".", ".");

        return redirect('/order/change')->with(['kembali' => $kembalian]);
    }

    public function finish()
    {
        $kembali = Session::get('kembali');

        if ($kembali == '') {
            return redirect('/');
        }
        return view('page/order/finish')->with(['kembali' => $kembali]);
        # code...
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  order-{id}, jumlah-{id}
     * @return view
     */
    public function ordering(Request $request)
    {
        // return $request;
        // if (!Auth::check()) {
        //     return redirect('login');
        // }

        $lists = array();
        $total = 0;
        $ppn = $this->ppn;
        for ($i = 1; $i <= $request->counter; $i++) {
            $order = 'order-' . $i;
            $input = 'input-' . $i;
            // echo 'find : ' .  $request->$order;
            $lists[$i] = Product::where('id', $request->$order)->first();

            // $lists[$i]->duration = $request->$duration;
            $lists[$i]->jumlah = $request->$input;
            $lists[$i]->subtotal = $request->$input * $lists[$i]->price;

            $total += $lists[$i]->subtotal;
            $lists[$i]->subtotal = 'Rp ' . number_format($lists[$i]->subtotal, 0, ".", ".");
            $lists[$i]->price = 'Rp ' . number_format($lists[$i]->price, 0, ".", ".");
        }
        $jumlah_ppn = ($ppn / 100) * $total;
        if ($jumlah_ppn + $total > 1000 / 2) {
            $bulat = ceil((($jumlah_ppn + $total) / 1000) * 2) / 2 * 1000 - ($jumlah_ppn + $total);
        } else {
            $bulat = 0;
        }


        return view('page/order/checkout')->with([
            'counter' => $request->counter,
            'carts' => $lists,
            'total' => 'Rp ' . number_format($total, 0, ".", "."),
            'ppn' => $ppn,
            'ppnTotal' => 'Rp ' . number_format($jumlah_ppn, 0, ".", "."),
            'ppn_total' => 'Rp ' . number_format($jumlah_ppn + $total, 0, ".", "."),
            'grandTotal' => 'Rp ' . number_format($jumlah_ppn + $total + $bulat, 0, ".", "."),
            'pembulatan' => 'Rp ' . number_format($bulat, 0, ".", "."),
            'rawGrandTotal' => $jumlah_ppn + $total + $bulat,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return json_encode(Order::all());
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
