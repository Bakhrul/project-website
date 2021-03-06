<?php

namespace App\Http\Controllers\Auth;

use App\m_user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Exception;
use Auth;
use Session;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login.index');
    }
    public function login(Request $request)
    {
        try {
            // dd($request->all());
            $user = m_user::where('u_email', $request->u_email)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Alamat email tidak ditemukan!');
            }
            if (!Hash::check($request->u_password, $user->u_password)) {
                return redirect()->back()->with('error', 'Password tidak sesuai!');
            }

            if($user->u_verification == '0'){
                return redirect()->back()->with('error', 'Silahkan verifikasi pendaftaran terlebih dahulu, cek inbox atau spam email anda!');
            }
            Auth::login($user);
            return redirect()->intended('/');

        } catch (\Throwable $th) {
            $code = 500;
            if ($th->getCode() == 400) {
                $code = 400;
            }
            return abort(500);
        }
    }
    protected function logout()
    {
        Auth::guard()->logout();
        Session::flush();

        return redirect()->route('login.index');
    }
}
