<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;



class DashboardController extends Controller
{
    public function index()
    {
        // Contoh data sederhana
        $totalOrders = Order::count();
        $sumstockProducts = Product::sum('stok');
        $sumtotalOrders = Order::whereIn('status_order', [1, 2, 3, 4,5,6])->sum('total');

        $totalProducts = Product::count();
        $OrdersMasihProsess = Order::whereIn('status_order', [1, 2, 3, 4])->count();
        $totalMasihProsess = Order::whereIn('status_order', [1, 2, 3, 4])->sum('total');

        $Orederterkirim = Order::where('status_order', 4)->count();
        $totalTerkirim = Order::where('status_order', 4)->sum('total');

        $Orderselesai = Order::where('status_order', 5)->count();
        $totalSelesai = Order::where('status_order', 5)->sum('total');

        $OrderBatal = Order::where('status_order', 6)->count();
        $totalBatal = Order::where('status_order', 6)->sum('total');
        $statusLabels = [
            0 => 'Belum upload bukti pembayaran',
            1 => 'Sedang diverifikasi oleh admin',
            2 => 'Bukti pembayaran terkonfirmasi / Sedang dipacking',
            3 => 'Barang selesai dipacking / Menunggu pengiriman',
            4 => 'Dalam pengiriman',
            5 => 'Selesai / Barang diterima',
            6 => 'Kadaluarsa / Pesanan dibatalkan',
        ];

        $orders = Order::latest()->take(5)->get();

        return view('dashboard', compact(
            'OrdersMasihProsess',
            'totalMasihProsess',
            'Orederterkirim',
            'totalTerkirim',
            'Orderselesai',
            'totalSelesai',
            'OrderBatal',
            'totalBatal',
            'totalOrders',
            'totalProducts',
            'statusLabels',
            'orders',
            'sumtotalOrders',
            'sumstockProducts'
        ));
    }

    public function export(Request $request)
    {

        $startDate = $request->query('start_date'); 
        $endDate = $request->query('end_date');    
        $statusOrder = $request->query('status_order');

        $query = Order::with('user')->latest();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($statusOrder !== null && $statusOrder !== '') {
            $query->where('status_order', $statusOrder);
        }

        $orders = $query->get();

        // Buat Excel
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser("orders.xlsx");

        // Header
        $header = [
            WriterEntityFactory::createCell('ID'),
            WriterEntityFactory::createCell('User'),
            WriterEntityFactory::createCell('Total'),
            WriterEntityFactory::createCell('Status'),
            WriterEntityFactory::createCell('Created At'),
        ];
        $writer->addRow(WriterEntityFactory::createRow($header));

        $statusLabels = [
            0 => 'Belum upload bukti pembayaran',
            1 => 'Sedang diverifikasi oleh admin',
            2 => 'Bukti pembayaran terkonfirmasi / Sedang dipacking',
            3 => 'Barang selesai dipacking / Menunggu pengiriman',
            4 => 'Dalam pengiriman',
            5 => 'Selesai / Barang diterima',
            6 => 'Kadaluarsa / Pesanan dibatalkan',
        ];

        foreach ($orders as $order) {
            $row = [
                WriterEntityFactory::createCell($order->id),
                WriterEntityFactory::createCell($order->user->name ?? '-'),
                WriterEntityFactory::createCell($order->total),
                WriterEntityFactory::createCell($statusLabels[$order->status_order] ?? '-'),
                WriterEntityFactory::createCell($order->created_at->format('Y-m-d H:i')),
            ];
            $writer->addRow(WriterEntityFactory::createRow($row));
        }

        $writer->close();
    }
}
