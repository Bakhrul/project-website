<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;

class SaldoController extends Controller
{
    public function index(){
        return view('admin.master.saldo.index');
    }

    public function datatable() {
		$item = DB::table('m_saldo')->orderBy('created_at','desc');

		return Datatables::of($item)
			->addIndexColumn()
            ->addColumn('nominal', function ($item) {
				if ($item->s_price == NULL) {
					return '<div>0.00</div>';
				}else {
					return number_format($item->s_price, 2);
				}
			})
			->addColumn('action', function ($item) {
				$edit = '<button class="btn btn-xs btn-warning mr-2" type="button" onclick="editSaldo(' . $item->s_id . ')"><i class="fa fa-pencil"></i></button>';
                $delete = '<button class="btn btn-xs btn-danger" type="button" onclick="deleteSaldo(' . $item->s_id . ')"><i class="fa fa-trash"></i></button>';
				return '<div>' . $edit . $delete . '</div>';
			})
			->rawColumns(['action'])
			->make(true);
	}


    public function store(Request $request){
        DB::BeginTransaction();
        try {

			DB::table('m_saldo')->insert([
				's_price' => str_replace(",", "", $request->s_price),
			]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambahkan data saldo',
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
            $saldo = DB::table('m_saldo')->where('s_id',$id)->first();

            if (!$saldo) {
                throw new Exception('Data saldo tidak ditemukan!', 400);
            }

			return response()->json([
                'status' => 'success',
                'data' => $saldo,
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

            $saldo = DB::table('m_saldo')->where('s_id',$id)->first();

            if (!$saldo) {
                throw new Exception('Data saldo tidak ditemukan!', 400);
            }

			DB::table('m_saldo')->where('s_id',$id)->update([
                's_price' => str_replace(",", "", $request->s_price),
            ]);

			DB::commit();

			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memperbarui data saldo',
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
            $saldo = DB::table('m_saldo')->where('s_id',$id)->first();

            if (!$saldo) {
                throw new Exception('Data saldo tidak ditemukan!', 400);
            }
            DB::table('m_saldo')->where('s_id',$id)->delete();

            DB::commit();
			return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data saldo',
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
