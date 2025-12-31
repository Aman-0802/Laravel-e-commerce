<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // All orders
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // Single order
    public function show($id)
{
    $order = Order::with([
        'user',
        'orderItems.product'
    ])->findOrFail($id);

    return view('admin.orders.show', compact('order'));
}


    // Orders of specific user
    public function userOrders($userId)
    {
        $orders = Order::where('user_id', $userId)
            ->with('items.product')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders.user-orders', compact('orders'));
    }

    // Update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated');
    }

      public function edit($id)
    {
       $order = Order::with('orderItems.product')->findOrFail($id);

        $products = Product::all(); // Product list to change items
        return view('admin.orders.edit', compact('order', 'products'));
    }

    // Update order
    public function update(Request $request, $id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        // Loop through submitted items
        $items = $request->input('items', []);

        foreach ($order->orderItems as $orderItem) {
            if(isset($items[$orderItem->id])) {
                $quantity = (int) $items[$orderItem->id]['quantity'];
                $product_id = (int) $items[$orderItem->id]['product_id'];

                if($quantity > 0){
                    $orderItem->update([
                        'quantity' => $quantity,
                        'product_id' => $product_id,
                    ]);
                } else {
                    $orderItem->delete(); // remove item if quantity 0
                }
            } else {
                $orderItem->delete(); // remove unchecked items
            }
        }

        // Recalculate total_amount
        $total = $order->orderItems()->sum(function($item){
            return ($item->product->sell_rate ?? 0) * $item->quantity;
        });
        $order->update(['total_amount' => $total]);

        return redirect()->route('admin.orders.edit', $order->id)->with('success', 'Order updated successfully!');
    }
}

