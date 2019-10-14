<?php

namespace App\Http\Controllers;

use App\Product;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) { 
            return response()->json([
                'errors' => [
                        'code' => 'ERROR-1',
                        'title' => 'UnprocessableEntity'
                    ]], 422);
        }
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
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) { 
            return response()->json([
                'errors' => [
                        'code' => 'ERROR-1',
                        'title' => 'UnprocessableEntity'
                    ]], 422);
        }
        $product = Product::find($id);
        if (!$product) { return response()->json([
            'errors' => [
                    'code' => 'ERROR-2',
                    'title' => 'NotFound'
                ]], 404); }
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
        $product = Product::find($id);
        if (!$product) { return response()->json([
            'errors' => [
                    'code' => 'ERROR-2',
                    'title' => 'NotFound'
                ]], 404); }
        Product::destroy($id);
        return response()->status(204);
    }
}