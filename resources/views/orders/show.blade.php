<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Order #{{ $order->id }}
        </h2>
    </x-slot>

    {{-- <div class="py-6" x-data="{ openPreview:false }"> --}}
    <div class="py-6" x-data="{ openPreview: false }" x-cloak>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ======== INFORMASI ORDER + BUKTI PEMBAYARAN ======== --}}
           <div class="bg-white shadow rounded p-4 mb-4 flex items-start gap-6">

    {{-- Bagian teks --}}
    <div class="flex-1">
        <h5>User: {{ $order->user->name ?? '-' }}</h5>
        <h5>Total: Rp {{ number_format($order->total, 0, ',', '.') }}</h5>
        <h5>Status:
            @php
                $statusLabels = [
                    0 => 'Belum upload bukti bayar',
                    1 => 'Sudah upload bukti bayar',
                    2 => 'Sudah konfirmasi bukti bayar',
                    3 => 'Selesai packing',
                    4 => 'Kirim',
                    5 => 'Selesai',
                    6 => 'Expired',
                ];
            @endphp
            {{ $statusLabels[$order->status_order] ?? '-' }}
        </h5>
    </div>

    {{-- Bukti Pembayaran --}}
    <div class="text-center">
        <h5 class="font-semibold mb-1">Bukti Pembayaran:</h5>

        @if ($order->payment_proof)
            <img 
                src="{{ $order->payment_proof }}"
                class="w-40 h-40 object-cover rounded cursor-pointer hover:opacity-80 transition"
                @click="openPreview = true"
            >
        @else
            <p class="text-gray-500">Belum upload bukti bayar</p>
        @endif
    </div>

</div>


            {{-- ======== ITEMS ======== --}}
            <div class="bg-white shadow rounded p-4">
                <h5>Items</h5>
                <table class="min-w-full divide-y divide-gray-200 table-auto">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name ?? '-' }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp {{ number_format($item->product->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->qty * $item->product->harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        @if ($order->items->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada item</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- ======== FORM UPDATE STATUS ======== --}}
            <div class="bg-white shadow rounded p-4 mb-4">
                <h5>Ubah Status Order</h5>

                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        @php
                            $statusLabels = [
                                2 => 'Sudah konfirmasi bukti bayar',
                                3 => 'Selesai packing',
                                4 => 'Kirim',
                                5 => 'Selesai',
                                6 => 'Expired',
                            ];

                            $currentRole = auth()->user()->roles->pluck('name')->first();
                            $canSubmit = false;
                            $allowedOptions = [];

                            if ($currentRole == 'admin') {
                                $canSubmit = true;
                                $allowedOptions = array_keys($statusLabels);
                            } elseif ($currentRole == 'cs1' && $order->status_order == 1) {
                                $canSubmit = true;
                                $allowedOptions = [2];
                            } elseif ($currentRole == 'cs2') {
                                if ($order->status_order == 2) {
                                    $canSubmit = true;
                                    $allowedOptions = [3];
                                } elseif ($order->status_order == 3) {
                                    $canSubmit = true;
                                    $allowedOptions = [4];
                                }
                            }
                        @endphp

                        <select name="status_order" class="form-select" required {{ $canSubmit ? '' : 'disabled' }}>
                            @foreach ($statusLabels as $key => $label)
                                @if (in_array($key, $allowedOptions))
                                    <option value="{{ $key }}"
                                        {{ $order->status_order == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @elseif($order->status_order == $key)
                                    <option value="{{ $key }}" selected>{{ $label }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    @if ($canSubmit)
                        <button type="submit"
                            class="ml-2 flex flex-1 items-center justify-center gap-2 bg-green-600 text-sm text-white px-3 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                            Update Status
                        </button>
                    @endif
                </form>
            </div>

            <a href="{{ route('orders.index') }}"
                class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition font-semibold">
                Kembali
            </a>
        </div>
       @if ($order->payment_proof)
<div 
    x-cloak
    x-show="openPreview"
    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
    x-transition
>
    <div class="relative bg-white p-3 rounded-lg max-w-[80vw] max-h-[80vh] overflow-auto shadow-lg">

        <!-- Tombol close -->
        <button 
            class="absolute top-2 right-2 z-50
                   bg-black bg-opacity-50 text-white 
                   w-10 h-10 flex items-center justify-center 
                   rounded-full text-2xl hover:bg-opacity-70 transition"
            @click="openPreview = false"
        >
            &times;
        </button>

        <!-- Gambar -->
        <img 
            src="{{ $order->payment_proof }}"
            class="max-w-[70vw] max-h-[90vh] rounded-lg shadow-lg transform transition hover:scale-110"
        >
    </div>
</div>
@endif


    </div>



</x-app-layout>
