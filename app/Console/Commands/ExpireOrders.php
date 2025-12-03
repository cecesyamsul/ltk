<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class ExpireOrders extends Command
{
   
    protected $signature = 'orders:expire';
    protected $description = 'Update status_order menjadi 6 jika belum upload bukti transfer 24 jam';
    public function handle()
    {
        
        $orders = Order::where('status_order', 0)->get();

        foreach ($orders as $order) {
            if ($order->created_at->diffInHours(Carbon::now()) >= 24) {
                $order->update(['status_order' => 6]);
                $this->info("Order ID {$order->id} diupdate menjadi kadaluarsa.");
            }
        }

        $this->info('Proses expire orders selesai.');
    }
}
