<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;
    protected function redirectTo()
    {
        if (Auth::user()->akses === 'operator') {
            $this->redirectTo = '/operator/beranda';
            return $this->redirectTo;
        } elseif (Auth::user()->akses === 'wali') {
            $this->redirectTo = '/walimurid/beranda';
            return $this->redirectTo;
        } else {
            return '/home';
        }
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ];
    }
}
