<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cart = [];
        if( Cart::count() ) {
            $cart = Cart::content();
        }

        return response()->json($cart);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Product $product)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });

        // TODO: Update cart if item already by adding up qty

        if ($duplicates->isEmpty()) {
            Cart::add($product->id, $product->name, 1, $product->price)
                ->associate(Product::class);
        }

        return response()->json(Cart::content());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });

        if ($cartItem->isNotEmpty()) {
            $rowId = $cartItem->first()->rowId;
            Cart::remove($rowId);
        }

        return response()->json(Cart::content());
    }
}
