<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register.index');
    }
    public function register(Request $request){
        DB::BeginTransaction();
        try {

            $validateEmail = DB::table('m_user')->where('u_email',$request->u_email)->first();
            if($validateEmail){
                throw new Exception('Email sudah digunakan, gundakan email lainnya!', 400);
            }

            DB::table('m_user')->insert([
                'u_token' =>  Str::random(50),
                'u_name' => $request->u_name,
                'u_email' => $request->u_email,
                'u_password' => Hash::make($request->u_password),
                'u_saldo' => '0',
                'u_type' => 'pengguna',
                'u_verification' => '0',
            ]);

            //send email verifikasi


			DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mendaftarkan akun pengguna. Silahkan cek inbox email anda, jika tidak ditemukan cek pada spam',
            ]);

		} catch (\Exception $th) {
            DB::rollBack();
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
		}
    }

    public function verifikasi(Request $request){
        DB::BeginTransaction();
        try {

            if(!$request->token){
                return abort(404);
            }
            $checkUser = DB::table('m_user')->where('u_token',$request->token)->first();
            if(!$checkUser){
                return abort(404);
            }
            if($checkUser->u_verification == '1'){
                return redirect()->route('login.index');
            }

            DB::table('m_user')->where('u_token',$request->token)->update([
                'u_verification' => '1',
            ]);

            DB::commit();
            return redirect()->route('login.index')->with('success', 'Terima kasih telah verifikasi akun pengguna anda.');

		} catch (\Exception $th) {
            dd($th);
            DB::rollBack();
            return abort(500);
		}
    }
}
