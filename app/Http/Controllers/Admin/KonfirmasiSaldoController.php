<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;

class KonfirmasiSaldoController extends Controller
{
    public function index(){
        return view('admin.konfirmasiSaldo.index');
    }

    public function datatable() {
		$item = DB::table('d_history_saldo')
                ->join('m_user','hs_user','u_id')
                ->orderBy('d_history_saldo.created_at','desc')
                ->select('d_history_saldo.*','u_name','u_email');

		return Datatables::of($item)
			->addIndexColumn()
            ->addColumn('tanggal', function ($item) {
				if ($item->created_at == NULL) {
					return '-';
				}else {
					return date('d/m/Y', strtotime($item->created_at));
				}
			})
            ->addColumn('nominal', function ($item) {
				if ($item->hs_price == NULL) {
					return '<div>0.00</div>';
				}else {
					return  number_format($item->hs_price, 2);
				}
			})
            ->addColumn('status',function($item){
                if($item->hs_status == 'waiting'){
                    return '<span class="label label-warning">Menunggu Pembayaran</span>';
                }else{
                    return '<span class="label label-success">Pembayaran Berhasil</span>';
                }
            })
			->addColumn('action', function ($item) {
				$edit = '<button class="btn btn-xs btn-success mr-2" type="button" onclick="konfirmasiSaldo(' . $item->hs_id . ')"><i class="fa fa-check"></i></button>';
                if($item->hs_status == 'accept'){
                    $edit = '';
                }
				return '<div>' . $edit  . '</div>';
			})
			->rawColumns(['action','tanggal','nominal','status'])
			->make(true);
	}


    public function konfirmasi(Request $request){
        DB::BeginTransaction();
        try {

            $id = $request->id;

            $pembelianSaldo = DB::table('d_history_saldo')->where('hs_id',$id)->first();

            if (!$pembelianSaldo) {
                throw new Exception('Data pembelian saldo tidak ditemukan!', 400);
            }
            $checkUser = DB::table('m_user')->where('u_id',$pembelianSaldo->hs_user)->first();
            if (!$checkUser) {
                throw new Exception('Data user tidak ditemukan!', 400);
            }
            $totalSaldo = $pembelianSaldo->hs_price + $checkUser->u_saldo;
			DB::table('d_history_saldo')->where('hs_id',$id)->update([
                'hs_status' => 'accept',
                'hs_confirmation_date' => Carbon::now('Asia/Jakarta'),
            ]);

            DB::table('m_user')->where('u_id',$pembelianSaldo->hs_user)->update([
                'u_saldo' => $totalSaldo,
            ]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyetujui pembelian saldo',
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
