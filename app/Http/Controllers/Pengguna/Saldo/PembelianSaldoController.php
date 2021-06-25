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



            // send email to user


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
