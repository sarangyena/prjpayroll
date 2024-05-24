<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    private $admin;
    private $current;

    public function __construct()
    {
        //Dates
        $this->current = Carbon::today();
        //Admin
        $this->admin = auth()->user();
    }
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
        if($request->user()->userType === 'ADMIN'){
            $log = [];
            $log['title'] = "LOGIN";
            $log['log'] = "User " . $request->user()->userName . " login.";
            $request->user()->log()->create($log);
            return redirect('admin/dashboard');
        }else if($request->user()->userType === 'QR'){
            return redirect('qr');
        }else{
            return redirect('employee/dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userName = $this->admin->userName;
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user = User::where("userName", $userName)->first();
        $log = [];
        $log['title'] = "LOGOUT";
        $log['log'] = "User ".$userName." logout.";
        $user->log()->create( $log );
        return redirect('/');
    }
}
