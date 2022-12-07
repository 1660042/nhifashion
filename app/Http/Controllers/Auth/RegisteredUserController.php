<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // dd(User::all());
        $request->validate([
            'ten' => ['required', 'string', 'max:255'],
            'sdt' => ['required', 'numeric', 'unique:users,sdt'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'sdt' => $request->sdt,
            'ten' => $request->ten,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_text' => $request->password,
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(RouteServiceProvider::ADMIN);
    }
}
