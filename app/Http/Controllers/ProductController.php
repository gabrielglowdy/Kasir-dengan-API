<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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

    public function get(Request $request)
    {
        if (isset($request->category)) {
            $p = Product::where('category', $request->category)->get();
        } else {
            $p = Product::all();
        }
        foreach ($p as $value) {
            $value->price = 'Rp ' . number_format($value->price, 0, ".", ".");
        }
        if (count($p) > 0) {
            //Exist
            $res = array(
                'status' => 200,
                'products' => $p
            );
        } else {
            $res = array(
                'status' => 404,
                'results' => 'null'
            );
        }
        return json_encode($res);
        // return response($res, $res['status'])->json();
        // $header->status = '200';
        // return response()->json($p, $res['status'],['status'=>'success']);
        // return json_encode($p);
    }

    public function findApi(Request $request)
    {

        if (isset($request->q)) {
            $id = $request->q;
        } else {
            return 'Need q param';
        }
        if (is_numeric($id)) {
            $p = Product::where('id', 'like', $id . '%')->get();
            if (count($p) == 0) {
                $p = Product::where('id', 'like', $id . '%')->orWhere('name', 'like', '%' . $id . '%')->orWhere('size', 'like', '%' . $id . '%')->get();
            }
        } else {
            $p = Product::where('id', 'like', $id . '%')->orWhere('name', 'like', '%' . $id . '%')->orWhere('size', 'like', '%' . $id . '%')->get();
        }
        foreach ($p as $key => $value) {
            $value->price = 'Rp ' . number_format($value->price, 0, ".", ".");
        }

        // $header->status = '200';
        // return response()->json($p, 200,['status'=>'success']);
        return json_encode($p);
    }

    public function getItem(Request $request)
    {
        if (isset($request->id) && $request->id != '') {
            $id = $request->id;
        } else {
            return 'need id param';
        }
        $p = Product::where('id', $id)->first();

        $p->rawPrice = $p->price;
        $p->price = 'Rp ' . number_format($p->price, 0, ".", ".");

        return json_encode($p);
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $product = Product::where('id', $id)->first();
        if ($product == null) {
            return redirect('/');
        }
        $product->name = $request->nama_produk;
        $product->desc = $request->desc_produk;
        $product->size = $request->ukuran_produk;
        $product->category = $request->kategori_produk;
        $product->price = $request->harga_produk;

        $product->save();
        return redirect('/product/list');
    }

    public function daftarProduk()
    {
        $products = Product::orderBy('category', 'asc')->get();
        // return $products;
        foreach ($products as $key => $value) {
            $category = Category::where('id', $value->category)->first();
            if ($category != null) {
                $value->category_name = $category->name;
                $value->category_id = $category->id;
            }else{
                $value->delete();
            }
            $value->price = 'Rp ' . number_format($value->price, 0, ".", ".");

        }
        return view('page/product/list')->with(['products' => $products]);
        # code...
    }

    public function tambah(Request $request)
    {
        $product = new Product();
        $product->name = $request->nama_produk;
        $product->desc = $request->desc_produk;
        $product->size = $request->ukuran_produk;
        $product->category = $request->kategori_produk;
        $product->price = $request->harga_produk;


        if (isset($request->id_produk) && $request->id_produk != '') {
            $find = Product::where('id', $request->id_produk)->get();
            if (count($find) == 0) {
                //Aman untuk set ID
                $product->id = $request->id_produk;
            }
        }

        $product->save();
        return redirect('/product/list');
    }

    public function showTambah()
    {

        $cat = Category::all();
        return view('page/product/tambah')->with(['category' => $cat]);
    }
    public function showEdit($id, Request $request)
    {

        $product = Product::where('id', $id)->first();
        $cat = Category::all();
        return view('page/product/edit')->with(['product' => $product, 'category' => $cat]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    public function delete($id, Request $request)
    {
        Product::where('id', $id)->delete();

        return redirect('/product/list');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
