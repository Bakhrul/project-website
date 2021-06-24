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

class HistorySaldoController extends Controller
{
    public function index(){

        $authId = Auth::user()->u_id;

        $history = DB::table('d_history_saldo')
        ->orderBy('d_history_saldo.created_at','desc')
        ->where('hs_user',$authId)
        ->paginate(10);

        return view('pengguna.pages.saldo.history.index',array(
            'history' => $history,
        ));
    }
    public function datatable() {
        $authId = '2';

        $item = DB::table('d_history_saldo')
                ->orderBy('d_history_saldo.created_at','desc')
                ->where('hs_user',$authId);

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
            ->rawColumns(['tanggal','nominal','status'])
            ->make(true);
    }

}
