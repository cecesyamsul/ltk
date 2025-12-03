<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Import Produk dari Excel</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

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

        <div class="mb-4 flex items-center space-x-4">
            <a href="{{ route('products.template.download') }}" target="_blank"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Download Template Excel
            </a>
        </div>

        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="file" class="block text-gray-700 font-medium">Pilih file Excel (.xlsx)</label>
                <input type="file" name="file" id="file" class="mt-2 p-2 border rounded w-full" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Upload
            </button>
        </form>

    </div>
</x-app-layout>
