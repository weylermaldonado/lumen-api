<?php

namespace App\Http\Controllers;

use App\Product;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Retrieve all the products stored.
     *
     * @return Response
     */

    public function getProducts()
    {
        $products = Product::all();

        return response()->json($products, 200);
    }

    /**
     * Store the new Product given the request body.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Retrieve the product for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function getProductById(String $id)
    {
        $product = Product::find($id);
        if (!$product) { return response()->json('No records found', 404); }
        return response()->json($product, 200);
    }

    /**
     * Update the product for the given ID.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function updateProductById(String $id, Request $request)
    {
        $product = Product::find($id);
        if (!$product) { return response()->json('No records found', 404); }
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();
        return response()->json($product, 200);
    }

    /**
     * Delete the product for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteProductById(String $id)
    {
        $product = Product::destroy($id);
        return response()->json('Product deleted', 200);
    }
}