<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class UserOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()->orders()
            ->where('status_order', 0)
            ->get();

        foreach ($orders as $order) {
            if ($order->created_at->diffInHours(Carbon::now()) >= 24) {
                $order->update([
                    'status_order' => 6
                ]);
            }
        }
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->get();
        return view('orders.history', compact('orders'));
    }
    public function upload(Request $request, $id)
    {
        try {
            $request->validate([
                'bukti' => 'required|image|max:2048',
            ]);

            $order = Order::findOrFail($id);

            $file = $request->file('bukti')->store('payments', 'public');
            $fileUrl = url('storage/' . $file);

            $order->update([
                'payment_proof' => $fileUrl,
                'status_order' => 1,
            ]);

            return back()->with('success_upload', 'Bukti pembayaran berhasil diupload!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function markComplete(Order $order)
    {
        if ($order->status_order == 4) {
            $order->update(['status_order' => 5]);
            return back()->with('success', 'Status order berhasil diperbarui menjadi Selesai.');
        }

        return back()->with('error', 'Status order tidak bisa diperbarui.');
    }
}
