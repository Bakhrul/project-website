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

class ResetPasswordController extends Controller
{
    public function index(){
        return view('auth.resetPassword.lupa');
    }

    public function lupaPassword(Request $request){
        DB::BeginTransaction();
        try {

            $validateUser = DB::table('m_user')->where('u_email',$request->u_email)->first();
            if(!$validateUser){
                throw new Exception('Email tidak ditemukan pada sistem kami!', 400);
            }

            //send email lupa password


			DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil lupa password akun pengguna. Silahkan cek inbox email anda, jika tidak ditemukan cek pada spam',
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

    public function resetPassword(Request $request){
        $token = $request->token;
        if(!$token){
            return abort(404);
        }
        $checkUser = DB::table('m_user')->where('u_token',$token)->first();
        if(!$checkUser){
            return abort(404);
        }
        return view('auth.resetPassword.reset',array(
            'user' => $checkUser,
        ));
    }

    public function resetPasswordProcess(Request $request){
        DB::BeginTransaction();
        try {
            if($request->new_password != $request->confirm_password){
                throw new Exception('Password baru dan konfirmasi password harus sama!', 400);
            }

            DB::table('m_user')->where('u_token',$request->token)->update([
                'u_password' => Hash::make($request->new_password),
            ]);

			DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil reset password akun pengguna',
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
}
