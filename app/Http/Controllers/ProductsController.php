<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use Validator;
use DB;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $field = $request->get('field') != '' ? $request->get('field') : 'product_name';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';
        $products = new Products;
        if($search)
            $products = $products->where('product_name', 'like', '%' . $search . '%');
        $products = $products->orderBy($field, $sort)
            ->paginate(5)
            ->withPath('?search=' . $search . '&field=' . $field . '&sort=' . $sort);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.createEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $this->validate($request,[
                'product_name'  => 'required',
                'product_description' => 'required',
                'product_qty' => 'required',
                'product_price' => 'required',
            ]);

            $product = new Products;
            $product->product_name = $request->product_name;
            $product->product_description = $request->product_description;
            $product->product_qty = $request->product_qty;
            $product->product_price = $request->product_price;
            $product->save();

        }catch(\exception $e){
            DB::rollback();
            return redirect('/products')->withErrors('Oops! something went wrong');
        }
        return redirect('/products')->withSuccess('Product created successfully!!');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::find($id);
        if(!empty($product)) {
            return view('products.createEdit', compact('product', 'id'));
        }
        return redirect('/products')->withErrors('Product not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        DB::beginTransaction();
        try{
            $this->validate($request,[
                'product_name'  => 'required',
                'product_description' => 'required',
                'product_qty' => 'required',
                'product_price' => 'required',
            ]);

            $product = Products::find($id);
            if(!empty($product)) {
                $product->product_name = $request->product_name;
                $product->product_description = $request->product_description;
                $product->product_qty = $request->product_qty;
                $product->product_price = $request->product_price;
                $product->save();
            }else{
                return redirect('/products')->withErrors('Product not found');
            }

        }catch(\exception $e){
            DB::rollback();
            return redirect('/products')->withErrors('Oops! something went wrong');
        }
        return redirect('/products')->withSuccess('Product updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        if(!empty($product)) {
            $product->delete();
        }else{
            return redirect('/products')->withErrors('Product not found');
        }
        return redirect('/products')->withSuccess('Product deleted successfully!!');
    }
}
