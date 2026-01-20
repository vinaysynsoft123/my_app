<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Services\DashboardService;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

       if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'))
            ->with('success', 'Welcome back, ' . auth()->user()->name . '!');
    }

   return back()
    ->withErrors(['email' => 'Invalid email or password.'])
    ->with('error', 'Login failed. Please check your credentials.')
    ->onlyInput('email');
    }

    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

       Auth::login($user);
        return redirect()->route('dashboard')
            ->with('success', 'Account created successfully! Welcome, ' . $user->name . '!');
            }

    // Dashboard (protected)
   public function dashboard(DashboardService $dashboardService)
    {
        $stats   = $dashboardService->stats();
        $reports = $dashboardService->recentBookings();    
        $todayCheckIns = $dashboardService->todayCheckIns();
        $todayCheckOuts = $dashboardService->todayCheckOuts();
        return view('dashboard', compact('stats', 'reports', 'todayCheckIns', 'todayCheckOuts'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }
}