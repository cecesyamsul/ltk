<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-6 py-4 bg-white shadow rounded-lg w-full">

            <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>

            <div class="flex items-center space-x-3 flex-nowrap">
                <a href="{{ route('products.import.view') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg 
                          hover:bg-indigo-700 transition">
                    + Import Excel
                </a>

                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg 
                          hover:bg-green-700 transition">
                    + Tambah Produk
                </a>
            </div>

        </div>
    </x-slot>

    {{-- Push CSS ke head --}}
    @push('head')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @endpush

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel Produk --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
                <table id="produk-table" class="min-w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Gambar</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Stok Awal</th>
                            <th class="px-4 py-2">Stok Sekarang</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Push JS --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#produk-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '{{ route('products.data') }}',
                    columns: [
                        {
                            data: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'image_url',
                            render: function(data) {
                                return data ? `<img src="${data}" class="w-12 h-12 object-cover rounded">` : '-';
                            },
                            orderable: false,
                            searchable: false
                        },
                        { data: 'name' },
                        {
                            data: 'harga',
                            render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                        },
                        { data: 'stok_awal' },
                        { data: 'stok' },
                        { data: 'aksi', orderable: false, searchable: false }
                    ],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Cari produk...",
                        paginate: { previous: "<", next: ">" }
                    },
                    pageLength: 10
                });
            });
        </script>
    @endpush
</x-app-layout>
