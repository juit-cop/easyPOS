<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with('orderItems.product')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'total_price' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'total_price' => $validatedData['total_price'],
        ]);

        foreach ($validatedData['products'] as $productId => $quantity) {
            if ($quantity > 0) {
                $order->orderItems()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }

        return redirect()->route('orders.show', $order)
            ->with('success', '注文が正常に作成されました。');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('orderItems.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $products = Product::all();
        $order->load('orderItems.product');
        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'total_price' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*' => 'required|numeric|min:0',
        ]);

        $order->update([
            'total_price' => $validatedData['total_price'],
        ]);

        // 既存の注文項目を削除
        $order->orderItems()->delete();

        // 新しい注文項目を作成
        foreach ($validatedData['products'] as $productId => $quantity) {
            if ($quantity > 0) {
                $order->orderItems()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }

        return redirect()->route('orders.show', $order)
            ->with('success', '注文が正常に更新されました。');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', '注文が正常に削除されました。');
    }
}