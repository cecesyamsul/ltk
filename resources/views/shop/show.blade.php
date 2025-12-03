<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Alert Sukses --}}



                {{-- Gambar Produk --}}
                <div class="md:w-1/2">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                        class="w-full h-auto object-cover rounded-lg shadow-lg">
                </div>

                {{-- Info Produk --}}
                <div class="md:w-1/2 flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-green-700">{{ $product->name }}</h1>
                        <p class="text-gray-500 mt-1">Stok: {{ $product->stok }} / {{ $product->stok_awal }}</p>
                        <p class="text-2xl font-bold text-green-600 mt-3">Rp {{ number_format($product->harga) }}</p>
                        <p class="text-gray-700 mt-4">{{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
                        </p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-6 flex gap-4">
                        @if (session('success'))
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                    role="alert">
                                    <strong class="font-bold">Sukses!</strong>
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                        <button onclick="this.parentElement.parentElement.remove();"
                                            class="text-green-700">&times;</button>
                                    </span>
                                </div>
                            </div>
                        @endif

                        {{-- Alert Error --}}
                        @if (session('error'))
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                    role="alert">
                                    <strong class="font-bold">Error!</strong>
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                        <button onclick="this.parentElement.parentElement.remove();"
                                            class="text-red-700">&times;</button>
                                    </span>
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ Crypt::encrypt($product->id) }}">

                            <button type="submit"
                                class="bg-green-200 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                                Tambah ke Keranjang
                            </button>
                        </form>

                        <a href="{{ route('home') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                            Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
