<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse;

class CustomLoginResponse implements LoginResponse
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->hasRole('pelanggan')) {
            return redirect()->route('home');
        }

        // if ($user->hasAnyRole(['admin'])) {
        //     return redirect()->route('products.index');
        // }
        // elseif ($user->hasAnyRole(['cs1', 'cs2'])) {
        //     return redirect()->route('orders.index');
        // }

        return redirect('/dashboard');
    }
}
