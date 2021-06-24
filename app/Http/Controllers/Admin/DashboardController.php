<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index(){
        $item = DB::table('m_item')->count();
        $pengguna = DB::table('m_user')->where('u_type','pengguna')->count();
        $pembelian = DB::table('d_history_saldo')->where('hs_type','in')->where('hs_status','accept')->select('hs_price')->get();
        $pendapatan = 0;
        foreach ($pembelian as $key => $value) {
            $pendapatan += $value->hs_price;
        }
        return view('admin.dashboard',array(
            'item' => $item,
            'pengguna' => $pengguna,
            'pendapatan' => $pendapatan,
        ));
    }
}
