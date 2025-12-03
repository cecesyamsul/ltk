<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Total Orders --}}
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-gray-500 text-sm font-semibold">Total Orders</h3>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $totalOrders }}
                        <span class="text-sm font-normal text-gray-600">
                            (Rp {{ number_format($sumtotalOrders, 0, ',', '.') }})
                        </span>
                    </p>
                </div>

                {{-- Total Products --}}
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-gray-500 text-sm font-semibold">Total Products</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }} <span
                            class="text-sm font-normal text-gray-600">Stok {{ $sumstockProducts }}</span></p>
                </div>

                {{-- Proccess Orders --}}
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-gray-500 text-sm font-semibold">Processing Orders</h3>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $OrdersMasihProsess }}
                        <span class="text-sm font-normal text-gray-600">
                            (Rp {{ number_format($totalMasihProsess, 0, ',', '.') }})
                        </span>
                    </p>
                </div>

                {{-- Canceled Orders --}}
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-gray-500 text-sm font-semibold">Canceled Orders</h3>
                    <p class="text-2xl font-bold text-red-600">
                        {{ $OrderBatal }}
                        <span class="text-sm font-normal text-gray-600">
                            (Rp {{ number_format($totalBatal ?? 0, 0, ',', '.') }})
                        </span>
                    </p>
                </div>

                {{-- Success Orders --}}
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-gray-500 text-sm font-semibold">Success Orders</h3>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $Orderselesai }}
                        <span class="text-sm font-normal text-gray-600">
                            (Rp {{ number_format($totalSelesai ?? 0, 0, ',', '.') }})
                        </span>
                    </p>
                </div>

                {{-- Send Orders --}}
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-gray-500 text-sm font-semibold">Sent Orders</h3>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ $Orederterkirim }}
                        <span class="text-sm font-normal text-gray-600">
                            (Rp {{ number_format($totalTerkirim ?? 0, 0, ',', '.') }})
                        </span>
                    </p>
                </div>

            </div>

            <div x-data="{ openFilter: false }" class="bg-white shadow rounded-lg p-4">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">5 Recent Orders</h3>

                    <button @click="openFilter = true"
                        class="px-3 py-1 bg-white-600 text-black rounded hover:bg-green-700 hover:text-gray transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" viewBox="0 0 24 24">
                            <rect width="24" height="24" rx="4" ry="4" fill="#217346" />
                            <path
                                d="M8 7 L10.5 12 L8 17 H9.5 L11.5 13.5 L13.5 17 H15 L12.5 12 L15 7 H13.5 L11.5 10.5 L9.5 7 H8 Z"
                                fill="white" />
                        </svg>
                        Export to excel
                    </button>
                </div>

                <div x-show="openFilter" x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">

                        <h4 class="font-semibold text-lg mb-4">Filter Orders</h4>

                        <button @click="openFilter = false"
                            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-xl font-bold">&times;</button>

                        <form action="{{ route('dashboard.export') }}" method="GET" class="space-y-4">

                            <div>
                                <label class="block font-medium mb-1">Status Order</label>
                                <select name="status_order" class="w-full border rounded px-3 py-2">
                                    <option value="">-- Semua Status --</option>
                                    @foreach ($statusLabels as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ request('status_order') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="w-full border rounded px-3 py-2"
                                    value="{{ request('start_date') }}">
                            </div>

                            <div>
                                <label class="block font-medium mb-1">Tanggal Akhir</label>
                                <input type="date" name="end_date" class="w-full border rounded px-3 py-2"
                                    value="{{ request('end_date') }}">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openFilter = false"
                                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Terapkan</button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Tabel Orders -->
                <table class="min-w-full table-auto divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">User</th>
                            <th class="px-4 py-2 text-left">Total</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-4 py-2">{{ $order->id }}</td>
                                <td class="px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $statusLabels[$order->status_order] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


        </div>
    </div>
</x-app-layout>
