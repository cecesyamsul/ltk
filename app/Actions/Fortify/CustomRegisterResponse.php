<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Http\Request;

class CustomRegisterResponse implements RegisterResponse
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->hasRole('pelanggan')) {
            return redirect()->route('home');
        }
        if ($user->hasAnyRole(['admin', 'cs1', 'cs2'])) {
            return redirect()->route('dashboard');
        }
        return redirect('/dashboard');
    }
}
