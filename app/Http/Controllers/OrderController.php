<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;



class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:cs1|cs2');
    }
    public function index()
    {
        Order::where('status_order', 0)
            ->where('created_at', '<', Carbon::now()->subDay())
            ->update(['status_order' => 6]);
        return view('orders.index');
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        // logic store order
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status_order' => 'required|integer|in:0,1,2,3,4,5,6',
        ]);

        $newStatus = $request->status_order;

        if ($newStatus == 2 && $order->status_order != 2) {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stok = max(0, $product->stok - $item->qty);
                    $product->save();
                }
            }
        }

        $order->update([
            'status_order' => $newStatus
        ]);

        return redirect()->route('orders.show',  Crypt::encryptString($order->id))
            ->with('success', 'Status order berhasil diperbarui');
    }



    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Order berhasil dihapus.');
    }


   public function show($encryptedId)
{
    $id = Crypt::decryptString($encryptedId); // DEKRIP
    $order = Order::findOrFail($id);

    return view('orders.show', compact('order'));
}


    public function getOrderItems($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return response()->json($order->items);
    }

    public function getOrders(Request $request)
    {
        $role = auth()->user()->roles->pluck('name')->first();

        $statusLabels = [
            0 => 'Belum upload bukti bayar',
            1 => 'Sudah upload bukti bayar',
            2 => 'Sudah konfirmasi bukti bayar',
            3 => 'Selesai packing',
            4 => 'Kirim',
            5 => 'Selesai',
            6 => 'Expired'
        ];

        $orders = Order::with('items', 'user')
            ->select('orders.*')
            ->orderBy('id', 'desc');

        return DataTables::of($orders)
            ->addIndexColumn()

            ->addColumn('user', fn($order) => $order->user->name ?? '-')

            ->addColumn('items_count', fn($order) => $order->items->count())

            ->addColumn('total', fn($order) => number_format($order->total, 0, ',', '.'))

            ->addColumn('status_order', function ($order) use ($statusLabels, $role) {

                $text = $statusLabels[$order->status_order] ?? '-';
                $blink = '';

                // 🔥 RULES BLINKING STATUS
                if ($role === 'cs1' && $order->status_order == 1) {
                    $blink = 'animate-blink';
                }

                if ($role === 'cs2' && in_array($order->status_order, [2, 3])) {
                    $blink = 'animate-blink';
                }

                return "<span class='{$blink}'>{$text}</span>";
            })

            ->addColumn(
                'created_at',
                fn($order) =>
                $order->created_at ? $order->created_at->format('d M Y H:i') : '-'
            )

            ->addColumn('action', function ($order) use ($role) {

                $blinkBtn = '';

                if ($role === 'cs1' && $order->status_order == 1) {
                    $blinkBtn = 'animate-blink';
                }

                if ($role === 'cs2' && in_array($order->status_order, [2, 3])) {
                    $blinkBtn = 'animate-blink';
                }

                return '
                <a href="' . route('orders.show', Crypt::encryptString($order->id)) . '"
   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 ' . $blinkBtn . '">
    Detail
</a>';
            })

            ->rawColumns(['status_order', 'action'])
            ->make(true);
    }

    public function countBlinkingOrders()
    {
        $role = auth()->user()->roles->pluck('name')->first();
        $query = Order::query();
        if ($role === 'cs1') {
            $query->where('status_order', 1);
        }

        if ($role === 'cs2') {
            $query->whereIn('status_order', [2, 3]);
        }

        $count = $query->count();

        return response()->json(['count' => $count]);
    }





    public function importView() {}
    public function import(Request $request) {}
    public function downloadTemplate() {}
}
