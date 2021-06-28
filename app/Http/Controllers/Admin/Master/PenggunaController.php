<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;
use Auth;

class PenggunaController extends Controller
{
    public function index(){

        // protect access admin
        $userId = Auth::user()->u_id;
        $dataAdmin = DB::table('m_user')->where('u_id',$userId)->where('u_type','admin')->first();
        if(!$dataAdmin){
            return abort(404);
        }


        return view('admin.master.pengguna.index');
    }

    public function datatable() {
		$item = DB::table('m_user')->where('u_type','pengguna');

		return Datatables::of($item)
			->addIndexColumn()
            ->addColumn('image',function($item){
                if($item->u_photo){
                    $url = url('/storage/images/pengguna/'.$item->u_photo);

                    return '<img src="' . $url . '" height="80px"
                    style="display:block;margin:0 auto 30px auto;">';
                }else{
                    $url = url('/admin-template/img/avatar-placeholder.png');
                    return '<img src="'.$url.'" height="80px"
                    style="display:block;margin:0 auto 30px auto;">';
                }
            })
            ->addColumn('saldo', function ($item) {
				if ($item->u_saldo == NULL) {
					return '<div>Rp 0.00</div>';
				}else {
					return 'Rp ' . number_format($item->u_saldo, 2);
				}
			})
			->addColumn('action', function ($item) {
                $delete = '<button class="btn btn-xs btn-danger" type="button" onclick="deletePengguna(' . $item->u_id . ')"><i class="fa fa-trash"></i></button>';
				return '<div>' . $delete . '</div>';
			})
			->rawColumns(['image','action','saldo'])
			->make(true);
	}

    public function show(Request $request){
        DB::BeginTransaction();
        try {
            $id = $request->id;
            $pengguna = DB::table('m_user')->where('u_id',$id)->first();

            if (!$pengguna) {
                throw new Exception('Data pengguna tidak ditemukan!', 400);
            }

			return response()->json([
                'status' => 'success',
                'data' => $pengguna,
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
            $pengguna = DB::table('m_user')->where('u_id',$id)->first();

            if (!$pengguna) {
                throw new Exception('Data pengguna tidak ditemukan!', 400);
            }
            DB::table('m_user')->where('u_id',$id)->delete();

            DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data pengguna',
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
