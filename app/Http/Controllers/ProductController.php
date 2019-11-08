<?php

namespace App\Http\Controllers;

use App\Product;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductResource as ProductResource;
use App\Http\Resources\ProductCollection as ProductCollection;

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

        return response()->json(ProductResource::collection($products), 200);
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
            'data' => 'required',
            'data.type' => 'required',
            'data.attributes' => 'required',
            'data.attributes.name' => 'required',
            'data.attributes.price' => 'required|numeric|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        { 
            return response()->json([
                'errors' => [
                        'code' => 'ERROR-1',
                        'title' => 'UnprocessableEntity'
                    ]], 422);
        }
        $product = new Product();
        $product->name = $request['data']['attributes']['name'];
        $product->price = $request['data']['attributes']['price'];
        $product->save();

        return response()->json(new ProductResource($product), 201);
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
        if (!$product)
        { 
            return response()->json([
                'errors' => [
                        'code' => 'ERROR-2',
                        'title' => 'NotFound'
                    ]], 404);
        }
        return response()->json(new ProductResource($product), 200);
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
            'data' => 'required',
            'data.type' => 'required',
            'data.attributes' => 'required',
            'data.attributes.name' => 'required',
            'data.attributes.price' => 'required|numeric|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        { 
            return response()->json([
                'errors' => [
                        'code' => 'ERROR-1',
                        'title' => 'UnprocessableEntity'
                    ]], 422);
        }
        $product = Product::find($id);
        if (!$product) 
        { 
            return response()->json([
                'errors' => [
                    'code' => 'ERROR-2',
                    'title' => 'NotFound'
                ]], 404); 
        }
        $product->name = $request['data']['attributes']['name'];
        $product->price = $request['data']['attributes']['price'];
        $product->save();
        return response()->json(new ProductResource($product), 200);
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
        if (!$product) 
        { 
            return response()->json([
                'errors' => [
                    'code' => 'ERROR-2',
                    'title' => 'NotFound'
                ]], 404); 
        }
        Product::destroy($id);
        return response(null, 204);
    }
}