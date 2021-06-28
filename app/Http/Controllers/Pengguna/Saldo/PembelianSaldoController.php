<?php

namespace App\Http\Controllers\Pengguna\Saldo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailSender;

class PembelianSaldoController extends Controller
{
    public function index(){
        $dataSaldo = DB::table('m_saldo')->orderBy('s_price')->get();
        return view('pengguna.pages.saldo.pembelian.index',array(
            'saldo' => $dataSaldo,
        ));
    }

    public function buySaldo(Request $request){
        DB::BeginTransaction();
        try {
            $authId = Auth::user()->u_id;
            $saldoId = $request->saldo;

            $saldo = DB::table('m_saldo')->where('s_id',$saldoId)->first();

            $dataUser = DB::table('m_user')->where('u_id',$authId)->first();
            if(!$dataUser){
                throw new Exception('Data user tidak ditemukan, coba muat login dahulu', 400);
            }

            if(!$saldo){
                throw new Exception('Data saldo tidak ditemukan, coba muat ulang halaman', 400);
            }

            DB::table('d_history_saldo')->insert([
                'hs_user' => $authId,
                'hs_price' => $saldo->s_price,
                'hs_name' => $saldo->s_name,
                'hs_status' => 'waiting',
                'hs_type' => 'in',
            ]);

            //send email to admin
            $dataAdmin = DB::table('m_user')->where('u_type','admin')->first();
            if($dataAdmin){
                $data = [
                  'token' => $dataAdmin->u_token,
                  'name' =>$dataAdmin->u_name,
                  'email' => $dataAdmin->u_email,
                  'saldo' => $saldo,
                  'user' => $dataUser,
                ];

                Mail::to($dataAdmin->u_email, $dataAdmin->u_name)->queue(new mailSender('mails.pembelian_saldo.admin', 'Pembelian Saldo Pengguna!', $data));
            }


            // send email to user

            $bank = DB::table('m_banks')->get();
            if($dataUser){
                $data = [
                  'token' => $dataUser->u_token,
                  'name' =>$dataUser->u_name,
                  'email' => $dataUser->u_email,
                  'saldo' => $saldo,
                  'bank' => $bank,
                ];

                Mail::to($dataUser->u_email, $dataUser->u_name)->queue(new mailSender('mails.pembelian_saldo.member', 'Pembelian Saldo!', $data));
            }


			DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil melakukan pembelian saldo. Silahkan cek inbox email anda, jika tidak ditemukan cek pada spam',
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
