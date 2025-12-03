<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                
                {{-- Validasi Error --}}
                <x-validation-errors class="mb-4" />

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">
                        <x-label for="name" value="Nama Produk" />
                        <x-input id="name" name="name" type="text" class="block mt-1 w-full" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="harga" value="Harga" />
                        <x-input id="harga" name="harga" type="text" class="block mt-1 w-full"  onkeyup="formatRupiah(this)"  required />
                    </div>

                    <div class="mb-4">
                        <x-label for="stok_awal" value="Stok Awal" />
                        <x-input id="stok_awal" name="stok_awal" type="number" class="block mt-1 w-full" required />
                    </div>

                    <div class="mb-4">
                        <x-label value="Tipe Gambar" />
                        <div class="flex items-center mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="image_type" value="url" class="form-radio" checked onchange="toggleImageInput(this)">
                                <span class="ml-2">URL Gambar</span>
                            </label>
                            
                            <label class="inline-flex items-center">
                                <input type="radio" name="image_type" value="file" class="form-radio" onchange="toggleImageInput(this)">
                                <span class="ml-2">Upload File</span>
                            </label>
                        </div>
                    </div>


                    <div class="mb-4" id="input-url">
                        <x-label for="image_url" value="URL Gambar" />
                        <x-input id="image_url" name="image_url" type="text" class="block mt-1 w-full" />
                    </div>

                    <div class="mb-4 hidden" id="input-file">
                        <x-label for="image_file" value="Upload Gambar" />
                        <input type="file" name="image_file" id="image_file" class="block mt-1 w-full" accept="image/*">
                        <p class="text-sm text-gray-500 mt-1">*Ukuran file tidak boleh lebih dari 2 MB</p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('products.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4 px-2">
                            Kembali
                        </a>

                        <x-button>
                            Simpan
                        </x-button>
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
