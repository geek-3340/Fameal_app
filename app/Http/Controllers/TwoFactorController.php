<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.verify-pin');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|digits:6',
        ]);

        $user = Auth::user();

        if ($user->two_factor_code !== $request->two_factor_code) {
            return back()->withErrors(['two_factor_code' => 'コードが間違っています。']);
        }
        if (now()->gt($user->two_factor_expires_at)) {
            return back()->withErrors(['two_factor_code' => 'コードの有効期限が切れています。']);
        }

        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        session(['two_factor_authenticated' => true]);

        return redirect()->intended(route('menus.month.index'));
    }

    public function regenerate()
    {
        $user = Auth::user();
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();
        $user->generateTwoFactorCode();
        return redirect()->route('verify.pin');
    }
}
