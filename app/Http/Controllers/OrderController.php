<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // All Orders / Bills
    public function index()
    {
        $orders = Order::with('user')->orderBy('id', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Single Order Detail
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function myOrders()
{
    $orders = Order::with('items.product')
                   ->where('user_id', Auth::id())
                   ->orderBy('id', 'desc')
                   ->get();

    return view('user.userAllOrders', compact('orders'));
}

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated');
    }

     public function success()
    {
        // Latest order of user
        $order = Order::where('user_id', auth()->id())
                      ->latest()
                      ->first();

      return view('user.orders.success', compact('order'));

    }

   public function downloadBill(Order $order)
{
    // Check if order belongs to logged-in user
    if ($order->user_id != auth()->id()) {
        abort(403, 'Unauthorized');
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.orders.bill', compact('order'));
    return $pdf->download('Order-'.$order->order_number.'.pdf');
}

}
