<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)
            ->where('status', 'active')
            ->with('items.product')
            ->firstOrFail();

        DB::transaction(function () use ($cart, $userId) {

            $billNo = 'ORD-' . time() . '-' . $userId;

            $totalAmount = $cart->items->sum(fn($i) => $i->qty * $i->price);

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $billNo,
                'total_amount' => $totalAmount,
                'status' => 'completed'
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->qty * $item->price
                ]);
            }

            $cart->items()->delete();
            $cart->update(['status' => 'completed']);
        });

        return redirect()->route('user.orders.success')
            ->with('success', 'Order placed successfully');
    }

}