<x-guest-layout>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-8">

        <h2 class="text-xl font-bold mb-4">Upload Bukti Pembayaran</h2>

        <p class="mb-4">Order ID: <strong>{{ $order->id }}</strong></p>
        <p>Total Pembayaran: <strong>Rp {{ number_format($order->total) }}</strong></p>

        @if(session('success'))
            <div class="bg-green-100 p-3 rounded mb-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 p-3 rounded mb-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('payment.upload.save', $order->id) }}" 
              method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="font-semibold">Upload Bukti Transfer</label>
                <input type="file" name="bukti" 
                       class="w-full border rounded px-3 py-2" accept="image/*"
                       required>
                @error('bukti')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button class="w-full bg-green-600 text-white py-2 rounded">
                Upload Sekarang
            </button>
        </form>
    </div>
</x-guest-layout>
