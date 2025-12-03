<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // $this->cart();
        $products = Product::all();
        return view('shop.index', compact('products'));
    }

    public function show($id)
    {
        try {
            // Decrypt ID
            $decryptedId = Crypt::decrypt($id);

            // Ambil produk
            $product = Product::findOrFail($decryptedId);

            return view('shop.show', compact('product'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function addToCart(Request $request)
    {
        try {
            $productId = Crypt::decrypt($request->product_id);
            $qty = $request->qty;
            $product = Product::findOrFail($productId);
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += (int)$qty;
            } else {
                $cart[$productId] = [
                    'id'       => $product->id,
                    'name' => $product->name,
                    'harga' => $product->harga,
                    'quantity' => $qty,
                ];
            }
            session()->put('cart', $cart);

            $cartCount = array_sum(array_column($cart, 'quantity'));
            session()->put('cart_count', $cartCount);
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ID produk tidak valid.');
        }
    }
    public function cart()
    {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }
        return view('shop.cart', compact('cart', 'cartCount', 'total'));
    }
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong.');
        }


        if (auth()->check()) {
            return redirect()->route('checkout.process');
        }


        return redirect()->route('checkout.choose');
    }
    public function choose()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang kosong.');
        }

        return view('checkout.choose');
    }
    public function guest()
    {
        session()->put('guest_checkout', true);
        return redirect()->route('checkout.process');
    }
    public function process()
    {
        $cart = session()->get('cart', []);
        $isGuest = session()->get('guest_checkout', false);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang kosong.');
        }

        // return view('checkout.process', compact('cart', 'isGuest'));
        $cart = session('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        $isGuest = !auth()->check();

        return view('checkout.process', [
            'cart'     => $cart,
            'total'    => $total,
            'isGuest'  => $isGuest
        ]);
    }

    public function submit(Request $request)
    {
        $cart = session('cart', []);


        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $isGuest = !Auth::check();

        // Jika Guest: Validasi input tamu
        if ($isGuest) {
            $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email',
                'guest_phone' => 'required|string|max:20',
                'guest_address' => 'required|string',
            ]);
        }

        DB::beginTransaction();

        try {
            if ($isGuest) {
                $user = User::where('email', $request->guest_email)->first();
                if (!$user) {
                    $user = User::create([
                        'name'    => $request->guest_name,
                        'email'   => $request->guest_email,
                        'address' => $request->guest_address,
                        'hp'      => $request->guest_phone,
                        'password' => bcrypt('guest1234'), // default password
                    ]);
                    $user->assignRole('pelanggan');
                }
            } else {
                $user = Auth::user();
            }


            $total = 0;
            foreach ($cart as $item) {
                $total += $item['harga'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total'   => $total,
                'status_order' => 0,
            ]);


            foreach ($cart as $productId => $item) {

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'qty'        => $item['quantity'],
                    'subtotal'   => $item['harga'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Hapus cart
            // session()->forget('cart');
            session()->forget(['cart', 'cart_count']);


            return redirect()
                ->route('checkout.success')
                ->with('order_id', $order->id)
                ->with('payment_info', [
                    'total' => $total,
                    'status' => 'Menunggu Pembayaran',
                    'rek' => 'BCA 123456789 a/n Toko Online',
                    'note' => 'Upload bukti transfer setelah pembayaran.'
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }


    public function success()
    {
        $orderId = session('order_id');
        $payment = session('payment_info');
        if (!$orderId || !$payment) {
            return redirect()->route('home');
        }
        return view('checkout.success', compact('orderId', 'payment'));
    }
}
