<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Produk --}}
                    <div class="mb-4">
                        <x-label value="Nama Produk" />
                        <x-input name="name" type="text" class="block mt-1 w-full" value="{{ $product->name }}" required />
                    </div>

                    {{-- Harga --}}
                    <div class="mb-4">
                        <x-label value="Harga" />
                        <x-input name="harga" type="text" onkeyup="formatRupiah(this)" onchange="formatRupiah(this)" class="block mt-1 w-full" value="{{ $product->harga }}" required />
                    </div>

                    {{-- Stok Awal --}}
                    <div class="mb-4">
                        <x-label value="Stok Awal" />
                        <x-input name="stok_awal" type="number" class="block mt-1 w-full" value="{{ $product->stok_awal }}" required />
                    </div>

                    {{-- Tipe Gambar --}}
                    <div class="mb-4">
                        <x-label value="Tipe Gambar" />
                        <div class="flex items-center mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="image_type" value="url" class="form-radio" 
                                    {{ $product->image_url && !is_file($product->image_url) ? 'checked' : '' }}
                                    onchange="toggleImageInput(this)">
                                <span class="ml-2">URL Gambar</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="image_type" value="file" class="form-radio" 
                                    {{ is_file($product->image_url) ? 'checked' : '' }}
                                    onchange="toggleImageInput(this)">
                                <span class="ml-2">Upload File</span>
                            </label>
                        </div>
                    </div>

                    {{-- Input URL --}}
                    <div class="mb-4" id="input-url" 
                        {{ $product->image_url && !is_file($product->image_url) ? '' : 'class=hidden' }}>
                        <x-label for="image_url" value="URL Gambar" />
                        <x-input id="image_url" name="image_url" type="text" class="block mt-1 w-full" value="{{ $product->image_url }}" />
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" class="mt-2 w-32 h-32 object-cover" alt="Preview">
                        @endif
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-4 {{ is_file($product->image_url) ? '' : 'hidden' }}" id="input-file">
                        <x-label for="image_file" value="Upload Gambar" />
                        <input type="file" name="image_file" id="image_file" class="block mt-1 w-full" accept="image/*" onchange="validateFileSize(this)">
                        <p class="text-sm text-gray-500 mt-1">*Ukuran file tidak boleh lebih dari 2 MB</p>
                        @if(is_file($product->image_url))
                            <img src="{{ asset('storage/'.$product->image_url) }}" class="mt-2 w-32 h-32 object-cover" alt="Preview">
                        @endif
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('products.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4 px-2">
                            Kembali
                        </a>
                        <x-button>Update</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleImageInput(el) {
            if(el.value === 'url') {
                document.getElementById('input-url').classList.remove('hidden');
                document.getElementById('input-file').classList.add('hidden');
            } else {
                document.getElementById('input-url').classList.add('hidden');
                document.getElementById('input-file').classList.remove('hidden');
            }
        }

        function validateFileSize(input) {
            const maxSize = 2 * 1024 * 1024; // 2 MB
            if(input.files[0] && input.files[0].size > maxSize) {
                alert('Ukuran file tidak boleh lebih dari 2 MB');
                input.value = '';
            }
        }
         function formatRupiah(input) {
    // hapus semua karakter kecuali angka
    let value = input.value.replace(/\D/g, '');

    // format ke rupiah
    input.value = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(value);
}
    </script>
</x-app-layout>
