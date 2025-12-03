<x-guest-layout>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">

    <h2 class="text-xl font-bold mb-6">Riwayat Order</h2>

    @php
        $statusLabels = [
            0 => 'Belum upload bukti pembayaran',
            1 => 'Sedang diverifikasi oleh admin',
            2 => 'Bukti pembayaran terkonfirmasi / Sedang dipacking',
            3 => 'Barang selesai dipacking / Menunggu pengiriman',
            4 => 'Dalam pengiriman',
            5 => 'Selesai / Barang diterima',
            6 => 'Kadaluarsa / Pesanan dibatalkan',
        ];
    @endphp

    @if ($orders->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($orders as $order)
               <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between" x-data="{ showModal: false }">
    <!-- Ringkasan Order -->
    <div class="space-y-1">
        <p><span class="font-semibold">ID Order:</span> {{ $order->id }}</p>
        <p><span class="font-semibold">Tanggal:</span> {{ $order->created_at->format('d M Y H:i') }}</p>
        <p><span class="font-semibold">Total:</span> Rp {{ number_format($order->total) }}</p>
    </div>

    <!-- Tombol aksi -->
    <div class="mt-2 flex flex-wrap gap-2">
        <!-- Tombol Detail Items -->
        <button @click="showModal = true"
            class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition font-semibold">
            Detail Items
        </button>

        <!-- Tombol Upload / Status -->
        @if ($order->status_order == 0)
            <div x-data="{ openUpload: false }">
                <button @click="openUpload = !openUpload"
                    class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 transition font-semibold">
                    {{ $statusLabels[$order->status_order] }}
                </button>

                <div x-show="openUpload" class="mt-2 p-4 border rounded bg-gray-50">
                    <form action="{{ route('orderan.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="bukti" accept="image/*" required
                            class="w-full border rounded px-3 py-2 mb-2">
                        <button type="submit"
                            class="w-full bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 transition font-semibold">
                            Upload
                        </button>
                    </form>
                </div>
            </div>
        @elseif($order->status_order == 4)
            <form action="{{ route('orderan.markComplete', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit"
                    class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition font-semibold">
                    {{ $statusLabels[$order->status_order] }} - Tandai Selesai
                </button>
            </form>
        @else
            <span class="px-3 py-2 rounded 
                @if ($order->status_order == 5) bg-green-100 text-green-700 
                @elseif($order->status_order == 6) bg-red-100 text-red-700 
                @else bg-yellow-100 text-yellow-700 @endif">
                {{ $statusLabels[$order->status_order] }}
            </span>
        @endif
    </div>

    <!-- Modal Detail Items -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-[80vh] overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Detail Items - Order #{{ $order->id }}</h2>
                <button @click="showModal = false" class="text-gray-500 hover:text-gray-800 font-bold">&times;</button>
            </div>

            <!-- Bukti Bayar -->
            <div class="mb-4">
                <p class="font-semibold mb-2">Bukti Pembayaran:</p>
                @if($order->bukti)
                    <img src="{{ asset('storage/' . $order->bukti) }}" alt="Bukti Pembayaran" class="w-40 h-40 object-cover rounded border">
                @else
                    <p class="text-gray-500">Belum ada bukti pembayaran</p>
                @endif
            </div>

            <!-- Table Items -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-2 py-1 text-left">Produk</th>
                            <th class="px-2 py-1 text-center">Qty</th>
                            <th class="px-2 py-1 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-2 py-1">{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</td>
                                <td class="px-2 py-1 text-center">{{ $item->qty }}</td>
                                <td class="px-2 py-1 text-right">Rp {{ number_format($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                <button @click="showModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

            @endforeach
        </div>
    @else
        <p class="text-gray-500">Belum ada order.</p>
    @endif

</div>
</x-guest-layout>
