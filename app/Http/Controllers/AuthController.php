<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->token = Cookie::get('token');
        $this->baseAPI = env('API_BACKEND');
    }

    public function login()
    {
        $response = Http::withToken(Cookie::get('token'))
            ->get(env('API_BACKEND') . '/api/user-profile');

        if ($response->ok()) {
            return redirect()->route('posts.index');
        } else {
            return view('login');
        }
    }

    public function prosesLogin()
    {
        $res = Http::post($this->baseAPI . '/api/login', [
            'email' => request('email'),
            'password' => request('password'),
        ]);

        if ($res->successful()) {
            $data = $res->json();
            Cookie::queue('token', $data['token'], 120);
            return redirect()->route(('posts.index'));
        } else {
            $data = $res->json();
            return back()->with('error', $data['error'] . '! ' . $data['messafe']);
        }
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget('token'));

        $res = HTTP::withToken($this->token)->post($this->baseAPI . '/api/logout');

        return view('login');
    }
}
