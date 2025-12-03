<x-guest-layout>



    @if (session('success_upload'))
        <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <button onclick="this.parentElement.parentElement.remove();" class="text-green-700">
                        &times;
                    </button>
                </span>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <button onclick="this.parentElement.parentElement.remove();" class="text-green-700">
                        &times;
                    </button>
                </span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <button onclick="this.parentElement.parentElement.remove();" class="text-red-700">&times;</button>
                </span>
            </div>
        </div>
    @endif




    {{-- Grid Produk --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Input Pencarian -->
        <input type="text" id="searchInput" placeholder="Cari produk..."
            class="w-full px-4 py-2 border rounded-lg mb-6 focus:outline-none focus:ring-2 focus:ring-green-500">

        <!-- Grid Produk -->
        <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div
                    class="product-card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition relative">
                    @if ($product->stok <= 0)
                        <span
                            class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow">Habis</span>
                    @elseif($product->stok_semu > 0)
                        <span
                            class="absolute top-2 left-2 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded shadow">Terbatas</span>
                    @endif

                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                        class="w-full max-h-40 object-cover hover:scale-105 transition-transform duration-300">

                    <div class="p-4 flex flex-col justify-between h-52">
                        <div>
                            <h3 class="font-semibold text-lg truncate product-name">{{ $product->name }}</h3>
                            <p class="mt-1 text-green-700 font-bold text-lg">Rp {{ number_format($product->harga) }}
                            </p>
                            <p class="text-gray-500 text-sm mt-1">Stok: {{ $product->stok }}</p>
                        </div>

                        <form action="{{ route('cart.add') }}" method="POST" class="mt-3 flex items-center space-x-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ Crypt::encrypt($product->id) }}">

                            <button type="button"
                                class="qty-btn px-2 py-1 bg-gray-200 rounded text-gray-700 hover:bg-gray-300"
                                data-action="decrease">-</button>
                            <input type="number" name="qty" min="1" max="{{ $product->stok }}"
                                value="1" class="qty-input w-12 text-center border rounded">
                            <button type="button"
                                class="qty-btn px-2 py-1 bg-gray-200 rounded text-gray-700 hover:bg-gray-300"
                                data-action="increase">+</button>

                            <button type="submit"
                                class="ml-2 flex flex-1 items-center justify-center gap-2 bg-green-600 text-sm text-white px-3 py-2 rounded-lg hover:bg-green-700 transition font-semibold">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="white" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.833l.383 1.437M7.5 14.25h11.39
            c.86 0 1.62-.585 1.82-1.42l1.35-5.39a1.125 1.125 0 0 0-1.09-1.39H5.82M7.5 14.25
            L5.106 5.27M7.5 14.25l-2.47 4.94M10.5 21a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm8.25 1.5
            a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                </svg>

                                Add to Cart
                            </button>

                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const productCards = document.querySelectorAll('.product-card');


        searchInput.addEventListener('input', function() {

            const query = this.value.toLowerCase();
            productCards.forEach(card => {
                console.log(card);
                const name = card.querySelector('.product-name').textContent.toLowerCase();
                if (name.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.qty-btn').forEach(button => {
            button.addEventListener('click', function() {
                const parent = this.closest('form'); // form container
                const input = parent.querySelector('.qty-input');
                let value = parseInt(input.value);

                if (this.dataset.action === 'increase') {
                    if (value < parseInt(input.max)) {
                        input.value = value + 1;
                    }
                } else if (this.dataset.action === 'decrease') {
                    if (value > parseInt(input.min)) {
                        input.value = value - 1;
                    }
                }
            });
        });
    </script>


</x-guest-layout>
