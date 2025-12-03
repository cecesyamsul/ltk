<x-guest-layout>
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Sebelum Checkout</h2>

        <p class="text-center text-gray-600 mb-4">
            Anda harus login atau checkout sebagai tamu.
        </p>

        <a href="{{ route('login') }}"
           class="block bg-green-600 text-white text-center py-2 rounded-lg mb-3">
           Login
        </a>

        <a href="{{ route('register') }}"
           class="block bg-blue-600 text-white text-center py-2 rounded-lg mb-3">
           Daftar
        </a>

        <a href="{{ route('checkout.guest') }}"
           class="block bg-gray-300 text-center py-2 rounded-lg">
           Checkout sebagai Tamu
        </a>
    </div>
</x-guest-layout>
