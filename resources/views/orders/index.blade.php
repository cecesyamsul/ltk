<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 bg-white shadow rounded-lg">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Orders
            </h2>

            <!-- Badge Notifikasi -->
            <span class="flex items-center gap-1 bg-red-600 text-white px-2 py-1 rounded-full text-xs font-bold">
                <span id="notifBlink"></span>
                <span>Need Confirm</span>
            </span>
        </div>
    </x-slot>

    {{-- Push CSS ke head --}}
    @push('head')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @endpush

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel Orders --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
                <table id="orders-table" class="min-w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Item</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200"></tbody>
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
                $('#orders-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('orders.data') }}',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'user', name: 'user.name' },
                        { data: 'total', name: 'total' },
                        { data: 'status_order', name: 'status_order' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'items_count', name: 'items_count', orderable: false, searchable: false },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Cari order...",
                        paginate: { previous: "<", next: ">" }
                    },
                    pageLength: 10
                });
            });

            // Update badge blinking setiap 3 detik
            setInterval(() => {
                fetch("/orders/blinking-count", {
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("notifBlink").innerText = data.count > 0 ? data.count : "";
                });
            }, 3000);
        </script>
    @endpush
</x-app-layout>
