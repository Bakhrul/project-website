<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;
use Auth;

class SatuanController extends Controller
{
    public function index(){
        // protect access admin
        $userId = Auth::user()->u_id;
        $dataAdmin = DB::table('m_user')->where('u_id',$userId)->where('u_type','admin')->first();
        if(!$dataAdmin){
            return abort(404);
        }

        return view('admin.master.satuan.index');
    }
    public function datatable() {
		$item = DB::table('m_unit')->orderBy('created_at','desc');

		return Datatables::of($item)
			->addIndexColumn()
			->addColumn('action', function ($item) {
				$edit = '<button class="btn btn-xs btn-warning mr-2" type="button" onclick="editSatuan(' . $item->u_id . ')"><i class="fa fa-pencil"></i></button>';
                $delete = '<button class="btn btn-xs btn-danger" type="button" onclick="deleteSatuan(' . $item->u_id . ')"><i class="fa fa-trash"></i></button>';
				return '<div>' . $edit . $delete . '</div>';
			})
			->rawColumns(['action'])
			->make(true);
	}

    public function store(Request $request){
        DB::BeginTransaction();
        try {

            $existing = DB::table('m_unit')->where('u_name',$request->u_name)->first();

            if ($existing) {
                throw new Exception('Nama satuan sudah ada, gunakan nama lainnya!', 400);
            }

			DB::table('m_unit')->insert([
				'u_name' => $request->u_name,
			]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Menambahkan data satuan',
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
            $satuan = DB::table('m_unit')->where('u_id',$id)->first();

            if (!$satuan) {
                throw new Exception('Data satuan tidak ditemukan!', 400);
            }

			return response()->json([
                'status' => 'success',
                'data' => $satuan,
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

            $satuan = DB::table('m_unit')->where('u_id',$id)->first();

            if (!$satuan) {
                throw new Exception('Data satuan tidak ditemukan!', 400);
            }

            $existing = DB::table('m_unit')->where('u_id','!=',$id)->where('u_name',$request->u_name)->first();
            if($existing){
                throw new Exception('Nama satuan sudah ada, gunakan nama lainnya!', 400);
            }

			DB::table('m_unit')->where('u_id',$id)->update([
                'u_name' => $request->u_name,
            ]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Memperbarui data satuan',
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
            $satuan = DB::table('m_unit')->where('u_id',$id)->first();

            if (!$satuan) {
                throw new Exception('Data satuan tidak ditemukan!', 400);
            }
            $existingItem = DB::table('m_item')->where('i_unit',$id)->count();
            if($existingItem > 0){
                throw new Exception('Masih ada item yang memiliki satuan ini, tidak bisa dihapus!', 400);
            }

            DB::table('m_unit')->where('u_id',$id)->delete();

            DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data satuan',
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
