<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartWebController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();
        $product = Product::find($request->product_id);

        // create or find cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->user_id],
            ['total_price' => 0]
        );

        // find existing item
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
                            ->where('product_id', $product->product_id)
                            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->subtotal = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $product->product_id,
                'quantity' => $request->quantity,
                'subtotal' => $product->price * $request->quantity,
            ]);
        }

        // update total
        $cart->total_price = $cart->cartItems()->sum('subtotal');
        $cart->save();

        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $item = CartItem::findOrFail($id);
        $item->quantity = $request->quantity;
        $item->subtotal = $item->quantity * $item->product->price;
        $item->save();

        $item->cart->update([
            'total_price' => $item->cart->cartItems()->sum('subtotal')
        ]);

        return back()->with('success', 'Jumlah produk diperbarui');
    }

    public function delete($id)
    {
        $item = CartItem::findOrFail($id);
        $cart = $item->cart;
        $item->delete();

        $cart->update([
            'total_price' => $cart->cartItems()->sum('subtotal')
        ]);

        return back()->with('success', 'Produk berhasil dihapus');
    }
}
