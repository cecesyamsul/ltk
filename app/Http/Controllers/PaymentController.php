<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class PaymentController extends Controller
{
    public function uploadForm($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('payment-upload', compact('order'));
    }

    public function upload(Request $request, $orderId)
    {
        $request->validate([
            'bukti' => 'required|image|max:2048',
        ]);

        $order = Order::findOrFail($orderId);

        $file = $request->file('bukti')->store('payments', 'public');
        $files =  url('storage/' . $file);

        $order->update([
            'payment_proof' => $files,
            'status_order'  => 1,
        ]);

        return redirect('/')
    ->with('success_upload', 'Bukti pembayaran berhasil diupload! Silakan tunggu konfirmasi admin.');

    }
}
