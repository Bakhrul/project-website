<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function index(){
        $satuan = DB::table('m_unit')->orderBy('created_at','desc')->get();
        return view('admin.master.item.index',array(
            'satuan' => $satuan
        ));
    }

    public function datatable() {
		$item = DB::table('m_item')
                ->join('m_unit','i_unit','u_id')
                ->orderBy('m_item.created_at','desc')
                ->select('m_item.i_name','m_item.i_id','m_unit.u_name','m_item.i_icon');

		return Datatables::of($item)
			->addIndexColumn()
            ->addColumn('image',function($item){
                if($item->i_icon){
                    $url = url('/storage/images/item/'.$item->i_icon);

                    return '<img src="' . $url . '" height="80px"
                    style="display:block;margin:0 auto 30px auto;">';
                }else{
                    $url = url('/admin-template/img/item.png');

                    return '<img src="'.$url.'" height="80px"
                    style="display:block;margin:0 auto 30px auto;">';
                }
            })
			->addColumn('action', function ($item) {
                $setting = '<button class="btn btn-xs btn-success mr-2" type="button" onclick="settingItem(' . $item->i_id . ')"><i class="fa fa-gear"></i></button>';
				$edit = '<button class="btn btn-xs btn-warning mr-2" type="button" onclick="editItem(' . $item->i_id . ')"><i class="fa fa-pencil"></i></button>';
                $delete = '<button class="btn btn-xs btn-danger" type="button" onclick="deleteItem(' . $item->i_id . ')"><i class="fa fa-trash"></i></button>';
				return '<div>' . $setting . $edit . $delete . '</div>';
			})
			->rawColumns(['image','action'])
			->make(true);
	}

    public function store(Request $request){
        DB::BeginTransaction();
        try {
            $i_icon = null;
			if ($request->hasFile("i_icon")) {

				$image = $request->file('i_icon');
				$namepasfoto = Str::random(40) . '.' . $image->getClientOriginalExtension();
				$destinationPath = storage_path() . '/app/public/images/item/';
				$image->move($destinationPath, $namepasfoto);
				$i_icon = $namepasfoto;

			}

			DB::table('m_item')->insert([
				'i_name' => $request->i_name,
                'i_unit' => $request->i_unit,
                'i_icon' => $i_icon,
			]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Menambahkan data item',
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
    public function show(Request $request){
        DB::BeginTransaction();
        try {
            $id = $request->id;
            $item = DB::table('m_item')->where('i_id',$id)->first();

            if (!$item) {
                throw new Exception('Data item tidak ditemukan!', 400);
            }

			return response()->json([
                'status' => 'success',
                'data' => $item,
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

    public function update(Request $request){
        DB::BeginTransaction();
        try {

            $id = $request->id;

            $item = DB::table('m_item')->where('i_id',$id)->first();

            if (!$item) {
                throw new Exception('Data item tidak ditemukan!', 400);
            }

			$existing = DB::table('m_item')->where('i_id','!=',$id)->where('i_name',$request->i_name)->first();
            if($existing){
                throw new Exception('Nama item sudah digunakan, gunakan nama lainnya!', 400);
            }

            $i_icon = $item->i_icon;
            if ($request->hasFile("i_icon")) {

				$image = $request->file('i_icon');
				$namepasfoto = Str::random(40) . '.' . $image->getClientOriginalExtension();
				$destinationPath = storage_path() . '/app/public/images/item/';
				$image->move($destinationPath, $namepasfoto);
				$i_icon = $namepasfoto;

			}


            DB::table('m_item')->where('i_id',$id)->update([
                'i_name' => $request->i_name,
                'i_unit' => $request->i_unit,
                'i_icon' => $i_icon
            ]);
			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Memperbarui data item',
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

    public function delete(Request $request){
        DB::BeginTransaction();
        try {
            $id = $request->id;
            $item = DB::table('m_item')->where('i_id',$id)->first();

            if (!$item) {
                throw new Exception('Data item tidak ditemukan!', 400);
            }
            DB::table('m_item')->where('i_id',$id)->delete();

            DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data item',
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

    public function priceDatatable(Request $request) {
        $itemId = $request->id;
		$item = DB::table('m_item_price')
                ->where('ip_item',$itemId)
                ->orderBy('ip_date','desc');

		return Datatables::of($item)
			->addIndexColumn()
            ->addColumn('tanggal',function($item){
                if(!$item->ip_date){
                    return '-';
                }
                return date('d-m-Y', strtotime($item->ip_date));
            })
            ->addColumn('nominal', function ($item) {
				if (!$item->ip_price) {
					return '<div>0.00</div>';
				}else {
					return number_format($item->ip_price, 2);
				}
			})
			->addColumn('action', function ($item) {
				$edit = '<button class="btn btn-xs btn-warning mr-2" type="button" onclick="editPrice(' . $item->ip_id . ')"><i class="fa fa-pencil"></i></button>';
				return '<div>' . $edit  . '</div>';
			})
			->rawColumns(['action'])
			->make(true);
	}

    public function priceStore(Request $request){
        DB::BeginTransaction();
        try {

            $periode = Carbon::parse($request->ip_date)->format('Y-m-d');

            $existing = DB::table('m_item_price')
                        ->where('ip_item',$request->ip_item)
                        ->where('ip_date',$periode)
                        ->first();

            if ($existing) {
                throw new Exception('Data harga item pada hari tersebut sudah ada!', 400);
            }

            DB::table('m_item_price')->insert([
                'ip_item' => $request->ip_item,
                'ip_date' => $periode,
                'ip_price' => $request->ip_price ? str_replace(",", "", $request->ip_price) : '0',

            ]);

            DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Menambahkan data harga item',
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

    public function priceShow(Request $request){
        DB::BeginTransaction();
        try {
            $id = $request->id;
            $itemPrice = DB::table('m_item_price')
                        ->where('ip_id',$id)
                        ->first();

            if (!$itemPrice) {
                throw new Exception('Data harga item pada hari tersebut tidak ditemukan!', 400);
            }
			return response()->json([
                'status' => 'success',
                'data' => $itemPrice,
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

    public function priceUpdate(Request $request){
        DB::BeginTransaction();
        try {

            $id = $request->id;
            $itemPrice = DB::table('m_item_price')
                        ->where('ip_id',$id)
                        ->first();

            if (!$itemPrice) {
                throw new Exception('Data harga item pada hari tersebut tidak ditemukan!', 400);
            }

            DB::table('m_item_price')->where('ip_id',$id)->update([
                'ip_price' => $request->ip_price ? str_replace(",", "", $request->ip_price) : '0',
            ]);
            DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Memperbarui data harga item',
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
