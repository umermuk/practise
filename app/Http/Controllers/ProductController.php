<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        return view('products.index', compact('categories'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    public function addToCartAjax(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = 1;

        $product = Product::find($productId);
        $user = auth()->check() ? auth()->user()->id : 0;
        $cart = session()->get('cart.' . $user, []);
        if (array_key_exists($productId, $cart)) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart.' . $user, $cart);
        return response()->json(['success' => true, 'message' => 'Product added to cart successfully']);
    }

    public function updateToCartAjax(Request $request)
    {
        $productId = $request->input('product_id');
        $type = $request->input('type');
        $quantityChange = 1;
        $user = auth()->check() ? auth()->user()->id : 0;

        $cart = session()->get('cart.' . $user, []);

        if (array_key_exists($productId, $cart)) {
            ($type == 'plus') ? $cart[$productId]['quantity'] += $quantityChange : $cart[$productId]['quantity'] -= $quantityChange;

            if ($cart[$productId]['quantity'] <= 0) {
                unset($cart[$productId]);
            }
        }

        session()->put('cart.' . $user, $cart);

        return response()->json(['success' => true, 'message' => 'Product updated to cart successfully']);
    }
}
