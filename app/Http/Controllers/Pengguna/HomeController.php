<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\m_item;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request){

        $itemData = m_item::orderBy('i_name','asc')->get();
        return view('pengguna.index',array(
            'item' => $itemData,
        ));
    }

    public function getDataTable(Request $request){
        $date1 = Carbon::parse($request->periode_first)->format('Y-m-d');
        $date2 = Carbon::parse($request->periode_second)->format('Y-m-d');

        $item = m_item::with(['priceOne' => function($q) use($date1){
            $q->whereDate('ip_date',$date1);
        }])
        ->with(['priceTwo' => function($q) use($date2){
            $q->whereDate('ip_date',$date2);
        }])
        ->join('m_unit','i_unit','u_id')
        ->get();

        return response()->json([
            'data' => $item,
        ]);
    }

    public function getGrafik(Request $request){
        $period = Carbon::now()->startOfMonth();
        if ($request->periode) {
            $period = carbon::parse($request->periode . '-01')->startOfMonth();
        }
        $itemId = $request->item;
        $month = $period->format('m');
        $year = $period->format('Y');
        $totalDays = $period->daysInMonth;

        $dateIncrement = $period->copy();
        $listPrice = [];

        for ($i = 1; $i <= $totalDays; $i++) {
            $itemPrice = DB::table('m_item_price')
                        ->whereDate('ip_date',$dateIncrement)
                        ->where('ip_item',$itemId)
                        ->select('ip_price')
                        ->first();
            if(!$itemPrice){
                array_push($listPrice, 0);
            }else{
                array_push($listPrice, $itemPrice->ip_price);
            }

            $dateIncrement = $dateIncrement->addDay();
        }

        return response()->json([
            'data' => $listPrice,
        ]);

    }
}
