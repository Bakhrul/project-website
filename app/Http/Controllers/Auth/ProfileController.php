<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Exception;
use Carbon\Carbon;
use Auth;

class ProfileController extends Controller
{
    public function index(){
        $authId = Auth::user()->u_id;
        $userData = DB::table('m_user')->where('u_id',$authId)->first();
        return view('auth.profile.index',array(
            'user' => $userData,
        ));
    }

    public function update(Request $request){
        DB::BeginTransaction();
        try {
            $authId = Auth::user()->u_id;

            $userData = DB::table('m_user')->where('u_id',$authId)->first();

            $u_photo = $userData->u_photo;
			if ($request->hasFile("u_photo")) {

				$image = $request->file('u_photo');
				$namepasfoto = Str::random(40) . '.' . $image->getClientOriginalExtension();
				$destinationPath = storage_path() . '/app/public/images/pengguna/';
				$image->move($destinationPath, $namepasfoto);
				$u_photo = $namepasfoto;

			}

            $u_password = $userData->u_password;
            if($request->u_password){
                $u_password = Hash::make($request->u_password);
            }
            DB::table('m_user')->where('u_id',$authId)->update([
                'u_name' => $request->u_name,
                'u_phone' => $request->u_phone,
                'u_photo' => $u_photo,
                'u_password' => $u_password,
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memperbarui data profile',
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
