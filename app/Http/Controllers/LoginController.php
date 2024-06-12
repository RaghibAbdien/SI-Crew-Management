<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        return view('pages.login-page');
    }

    public function login(Request $request){
        $infoLogin = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        try {
            if (Auth::attempt($infoLogin)) {
                $request->session()->regenerate();
                return to_route('dashboard');
            } else {
                return redirect('/')->with('error', 'Password atau Email anda salah!');
            }
        } catch (\Throwable $th) {
            return redirect('/')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function logout(){

        try {
            Log::info("User sedang mencoba untuk log out", ['user_id' => Auth::id()]);
            
            Auth::logout();
            
            Log::info("User berhasil melakukan log out");
            return redirect('/');
        } catch (Exception $e) {
            Log::info("Ada kesalahan saat melakukan log out", [
                'user_id' => Auth::id(),
                'error_message' => $e->getMessage(),
            ]);

            return with('error', "Ada error saat melakukan log out, Silahkan coba lagi");


        }
        
    }
}
