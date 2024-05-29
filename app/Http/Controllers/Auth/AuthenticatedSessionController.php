<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        if(User::where('user_name', $request->user_name)->first()->user_type == "USER"){
            return redirect()->intended(route('u-dashboard', absolute: false));
        }else if(User::where('user_name', $request->user_name)->first()->user_type == "QR"){
            return redirect()->intended(route('qr-scanner', absolute: false));
        }else{
            $user = User::where('user_name', $request->user_name)->first();
            $log = new Log();
            $log->title = 'LOGIN';
            $log->log = 'Admin '.auth()->user()->user_name.' login at '.Carbon::now();
            $log->user()->associate($user);
            $log->save();
            return redirect()->intended(route('a-dashboard', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = User::where('user_name', auth()->user()->user_name)->first();
        $log = new Log();
        $log->title = 'LOG OUT';
        $log->log = 'Admin '.auth()->user()->user_name.' logout at '.Carbon::now();
        $log->user()->associate($user);
        $log->save();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
