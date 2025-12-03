<x-guest-layout>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-8">

        <h2 class="text-xl font-bold mb-4">Checkout</h2>

        @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

        {{-- Jika tamu --}}
        @if($isGuest)
            <div class="bg-yellow-100 p-3 rounded mb-4 text-sm">
                Anda checkout sebagai tamu (guest). Silakan isi data berikut:
            </div>

            <form action="{{ route('checkout.submit') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="block font-semibold">Nama Lengkap</label>
                    <input type="text" name="guest_name"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="block font-semibold">Email</label>
                    <input type="email" name="guest_email"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- HP --}}
                <div class="mb-3">
                    <label class="block font-semibold">No. HP</label>
                    <input type="text" name="guest_phone"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="block font-semibold">Alamat Lengkap</label>
                    <textarea name="guest_address"
                              class="w-full border rounded px-3 py-2"
                              required></textarea>
                </div>

                {{-- Ringkasan Belanja --}}
                <h3 class="font-semibold mt-4 mb-2">Ringkasan Belanja:</h3>
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
                                class="bg-green-600 text-black px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-gray-500">Keranjang kosong.</p>
        @endif

                <button class="mt-4 w-full bg-green-600 text-black py-2 rounded-lg">
                    Selesaikan Checkout
                </button>
            </form>

        @else
        {{-- Untuk user yang login --}}
            <p>Halo, <strong>{{ Auth::user()->name }}</strong></p>

            <h3 class="font-semibold mt-4 mb-2">Ringkasan Belanja:</h3>
            <ul class="list-disc pl-5">
                @foreach($cart as $item)
                    <li>{{ $item['name'] }} ({{ $item['quantity'] }})</li>
                @endforeach
            </ul>

            <form action="{{ route('checkout.submit') }}" method="POST">
                @csrf
                <button class="mt-4 w-full bg-green-600 text-white py-2 rounded-lg">
                    Selesaikan Checkout
                </button>
            </form>
        @endif

    </div>
</x-guest-layout>
