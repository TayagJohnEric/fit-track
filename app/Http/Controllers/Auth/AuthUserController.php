<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{

public function showRegisterForm()
{
    return view('auth.user.register');
}

public function register(Request $request)
{
    try {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($user);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully! Welcome to Fit-Track!',
                'redirect_url' => route('onboarding.welcome')
            ]);
        }

        return redirect()->route('onboarding.welcome');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the errors below.',
                'errors' => $e->errors()
            ], 422);
        }
        
        throw $e;
        
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
                'errors' => ['general' => ['Registration failed: ' . $e->getMessage()]]
            ], 500);
        }
        
        return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
    }
}

    public function showLoginForm()
{
    return view('auth.user.login');
}

public function login(Request $request)
{
    try {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'user') {
                Auth::logout();
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access.',
                        'errors' => ['email' => ['Unauthorized access.']]
                    ], 422);
                }
                
                return back()->withErrors(['email' => 'Unauthorized access.']);
            }

            $request->session()->regenerate();
            
            // Determine redirect URL
            $redirectUrl = Auth::user()->userProfile 
                ? route('dashboard') 
                : route('onboarding.welcome');
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful! Redirecting...',
                    'redirect_url' => $redirectUrl
                ]);
            }
            
            // Check if user has completed onboarding (fallback for non-AJAX)
            if (Auth::user()->userProfile) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('onboarding.welcome');
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.',
                'errors' => ['email' => ['The provided credentials do not match our records.']]
            ], 422);
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the errors below.',
                'errors' => $e->errors()
            ], 422);
        }
        
        throw $e;
        
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage(),
                'errors' => ['general' => ['Login failed: ' . $e->getMessage()]]
            ], 500);
        }
        
        return back()->withErrors(['error' => 'Login failed: ' . $e->getMessage()]);
    }
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
