<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CartController extends Controller
{
    // View cart
    public function view()
    {
        $cart = Cart::with('items.product')  // Load items with product
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        return view('user.orders.cart', compact('cart'));
    }

    // Add product to cart
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status'  => 'active',
        ]);

        // check product already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // product already exists → qty increase
            $cartItem->qty += 1;
            $cartItem->save();
        } else {
            // new product → create new row
            CartItem::create([
                'cart_id'   => $cart->id,
                'product_id' => $product->id,
                'qty'       => 1,
                'price'     => $product->sell_rate,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function updateQty(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);

        if ($request->action === 'increase') {
            $item->qty += 1;
        }

        if ($request->action === 'decrease' && $item->qty > 1) {
            $item->qty -= 1;
        }

        $item->save();

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);

        $item->delete();

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function checkout()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.view')
                ->with('error', 'Your cart is empty');
        }

        return view('user.orders.checkout', compact('cart'));
    }


    public function placeOrder()
    {
        $cart = Cart::with('items')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $grandTotal = 0;
        foreach ($cart->items as $item) {
            $grandTotal += $item->qty * $item->price;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . time(), // ✅ MUST be here
            'total_amount' => $grandTotal,
            'status' => 'confirmed',
        ]);


        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->price,
            ]);
        }

        $cart->status = 'completed';
        $cart->save();

        CartItem::where('cart_id', $cart->id)->delete();

       return redirect()->route('user.orders.success')
                 ->with('success', 'Order placed successfully');

    }
}
