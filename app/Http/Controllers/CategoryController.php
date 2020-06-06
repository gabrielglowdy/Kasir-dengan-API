<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $category = Category::where('id', $id)->first();
        if ($category == null) {
            return redirect('/');
        }
        $category->name = $request->nama_kategori;
        $category->save();
        return redirect('/category/list');
    }

    public function tambah(Request $request)
    {
        $cat = Category::where('name', $request->nama_kategori)->get();
        if (count($cat) > 0) {
            return redirect('/category/list')->with(['error' => 'Nama Kategori sudah ada']);
        }
        $newCat = new Category();
        $newCat->name = $request->nama_kategori;
        $newCat->icon = 'svg';
        $newCat->save();

        return redirect('/category/list')->with(['success' => 'Kategori berhasil ditambahkan']);
    }

    public function showTambah()
    {
        return view('page/category/tambah');
    }

    public function showEdit($id)
    {
        $product = Category::where('id', $id)->first();
        return view('page/category/edit')->with(['product' => $product]);
        # code...
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        //Check Kategori tsb ada atau enggak
        if ($category != null) {
            //Check produk yang di dalam kategori tersebut
            $products = Product::where('category', $id)->get();
            if (count($products) > 0) {
                //If exist
                //Check Category 'Other'
                $otherName = 'Lain-lain';
                $cat = Category::where('name', $otherName)->first();
                if ($cat == null) {
                    $cat = new Category();
                    $cat->name = $otherName;
                    $cat->icon = 'svg';
                    $cat->save();
                }
                foreach ($products as $key => $value) {
                    $value->category = $cat->id;
                    $value->save();
                }
            }
            Category::where('id', $id)->delete();
        }
        return redirect('/category/list');
    }

    public function daftarProduk($id)
    {
        $category =  Category::where('id',$id)->first();
        $products = Product::where('category',$id)->get();
        if (count($products)==0 || $category == null) {
            return redirect('/daftar-produk');
        }
        foreach ($products as $key => $value) {
            $value->category_name = Category::where('id',$value->category)->first()->name;
            $value->price = 'Rp ' . number_format($value->price, 0, ".", ".");
        }
        return view('page/category/daftar-produk')->with(['products' => $products, 'category'=> $category]);
        # code...
    }

    public function daftar()
    {
        $products = Category::all();
        foreach ($products as $key => $value) {
            $prod = Product::where('category',$value->id)->get();
            $value->total_produk = count($prod);
        }
        // return $products;
        return view('page/category/list')->with(['products' => $products]);
        # code...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
