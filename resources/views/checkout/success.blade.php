<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        @if(session('order_id'))
    <div class="bg-green-100 p-4 rounded mb-4">
        <h2 class="text-xl font-bold">Pesanan Berhasil!</h2>
        <p>ID Pesanan: <strong>{{ session('order_id') }}</strong></p>
    </div>
@endif

@if(session('payment_info'))
    @php $pay = session('payment_info'); @endphp

    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-2">Informasi Pembayaran:</h3>
        <p>Total Pembayaran: <strong>Rp {{ number_format($pay['total']) }}</strong></p>
        <p>Status: <strong>{{ $pay['status'] }}</strong></p>
        <p>No. Rekening: <strong>{{ $pay['rek'] }}</strong></p>
        <p class="text-sm text-gray-600 mt-2">{{ $pay['note'] }}</p>

        <a href="{{ route('payment.upload', session('order_id')) }}"
           class="mt-4 block bg-green-600 text-white text-center py-2 rounded">
           Upload Bukti Pembayaran
        </a>
    </div>
@endif

@if(session('uploaded_success'))
    <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
        {{ session('uploaded_success') }}
    </div>
@endif

    </div>
    </x-guest-layout>