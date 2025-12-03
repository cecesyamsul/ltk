<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">

        {{-- Tombol Back --}}
        <div class="mb-4">
            <a href="{{ url()->previous() }}"
               class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition font-semibold">
                &larr; Kembali
            </a>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-6">Keranjang Belanja</h2>

        @if(count($cart) > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cart as $item)
                            <tr>
                                <td class="px-6 py-4 flex items-center gap-4">
                                    @if(isset($item['image_url']))
                                        <img src="{{ $item['image_url'] }}" class="h-12 w-12 object-cover rounded" alt="">
                                    @endif
                                    <span>{{ $item['name'] }}</span>
                                </td>
                                <td class="px-6 py-4">Rp {{ number_format($item['harga']) }}</td>
                                <td class="px-6 py-4">{{ $item['quantity'] }}</td>
                                <td class="px-6 py-4 font-bold">Rp {{ number_format($item['harga'] * $item['quantity']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-6 flex justify-between items-center">
                    <span class="text-xl font-bold">Total: Rp {{ number_format($total) }}</span>

                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-gray-500">Keranjang kosong.</p>
        @endif
    </div>
</x-guest-layout>
