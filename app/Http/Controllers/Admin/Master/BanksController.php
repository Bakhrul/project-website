<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;
use Auth;

class BanksController extends Controller
{
    public function index(){

        // protect access admin
        $userId = Auth::user()->u_id;
        $dataAdmin = DB::table('m_user')->where('u_id',$userId)->where('u_type','admin')->first();
        if(!$dataAdmin){
            return abort(404);
        }

        return view('admin.master.banks.index');
    }
    public function datatable() {
		$item = DB::table('m_banks')->orderBy('created_at','desc');

		return Datatables::of($item)
			->addIndexColumn()
			->addColumn('action', function ($item) {
				$edit = '<button class="btn btn-xs btn-warning mr-2" type="button" onclick="editBank(' . $item->b_id . ')"><i class="fa fa-pencil"></i></button>';
                $delete = '<button class="btn btn-xs btn-danger" type="button" onclick="deleteBank(' . $item->b_id . ')"><i class="fa fa-trash"></i></button>';
				return '<div>' . $edit . $delete . '</div>';
			})
			->rawColumns(['action'])
			->make(true);
	}

    public function store(Request $request){
        DB::BeginTransaction();
        try {

			DB::table('m_banks')->insert([
				'b_name' => $request->b_name,
                'b_number_account' => $request->b_number_account,
                'b_name_account' => $request->b_name_account,

			]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Menambahkan data bank',
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
            $bank = DB::table('m_banks')->where('b_id',$id)->first();

            if (!$bank) {
                throw new Exception('Data bank tidak ditemukan!', 400);
            }

			return response()->json([
                'status' => 'success',
                'data' => $bank,
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

            $bank = DB::table('m_banks')->where('b_id',$id)->first();

            if (!$bank) {
                throw new Exception('Data bank tidak ditemukan!', 400);
            }

			DB::table('m_banks')->where('b_id',$id)->update([
                'b_name' => $request->b_name,
                'b_number_account' => $request->b_number_account,
                'b_name_account' => $request->b_name_account,
            ]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Memperbarui data bank',
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
            $bank = DB::table('m_banks')->where('b_id',$id)->first();

            if (!$bank) {
                throw new Exception('Data bank tidak ditemukan!', 400);
            }
            DB::table('m_banks')->where('b_id',$id)->delete();

            DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data bank',
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
