<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Epresence; 
use App\Models\PersonalAccessToken;
use Validator;
use DateTime;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        if($user['npp_supervisor'] === null) {
            return response()
                ->json(['message' => 'Sorry you are not a user :)']);
        }

        return response()
        ->json(['message' => 'Success get data', 'data' => $user]);
    }

    public function addPresent(Request $request)
    {
        $user = auth()->user();

        if($user['npp_supervisor'] === null) {
            return response()
                ->json(['message' => 'Sorry you are not a user :)']);
        }

        $validator = Validator::make($request->all(),[
            'type' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
     
        $epresence = Epresence::create([
            'user_id' => auth()->user()->tokens()->first()->tokenable_id,
            'type' => $request->type,
            'is_approve' => 'false',
            'waktu' => $request->waktu,
        ]);

        return response()
            ->json(['message' => 'Success add data', 'data' => $request->all() ]);
    }

    public function getPresent()
    {
        $user = auth()->user();

        if($user['npp_supervisor'] === null) {
            return response()
                ->json(['message' => 'Sorry you are not a user :)']);
        }
        // return $user->id;
        // $bisa = User::with("epresence")->find($user->id);
        // // return $bisa;
        // $hasil = [];
        // foreach($bisa->epresence as $key => $value) {
        //     if($value->type === 'IN') {
        //         $dat = [
        //             'id_user' => $user->id,
        //             'nama_user' => $user->name,
        //             'tanggal' => $value->tanggal,
        //             'waktu_masuk' => $value->waktu_masuk,
        //             'waktu_pulang' => '17:00:00',
        //             'status_masuk' => $value->is_approve === 'true' ? 'APPROVE' : 'REJECT',
        //             'status_pulang' => $value->is_approve === 'true' ? 'APPROVE' : 'REJECT',
        //         ];
        //         // return $dat;
        //         // return $hasil[$dat];
        //     } else {
        //         $date = new DateTime($value->waktu);
        //         $waktu_pulang = $date->format('H:i:s');

        //         $dat2 = [
        //             'id_user' => $user->id,
        //             'nama_user' => $user->name,
        //             'waktu_masuk' => $waktu_masuk,
        //             'waktu_pulang' => $waktu_pulang,
        //             'status_masuk' => $value->is_approve === 'true' ? 'APPROVE' : 'REJECT',
        //             'status_pulang' => $value->is_approve === 'true' ? 'APPROVE' : 'REJECT',
        //         ];

        //         return $hasil[$dat2];
        //     }
        // }

        $inEpresence = Epresence::where('user_id', $user->id)->where('type', 'IN')->orderBy('waktu')->first();
        // return $inEpresence;
        $outEpresence = Epresence::where('user_id', $user->id)->where('type', 'OUT')->orderBy('waktu')->first();
        // return $outEpresence;

        $date = new DateTime($inEpresence->waktu);
        $tanggal = $date->format('Y-m-d');
        $waktu_masuk = $date->format('H:i:s');

        $dat = [
            'id_user' => $user->id,
            'nama_user' => $user->name,
            'tanggal' => $tanggal,
            'waktu_masuk' => $waktu_masuk,
            'waktu_pulang' => '17:00:00',
            'status_masuk' => $inEpresence->is_approve === 'true' ? 'APPROVE' : 'REJECT',
            'status_pulang' => $outEpresence->is_approve === 'true' ? 'APPROVE' : 'REJECT',
        ];

        $date = new DateTime($outEpresence->waktu);
        $waktu_pulang = $date->format('H:i:s');

        $dat2 = [
            'id_user' => $user->id,
            'nama_user' => $user->name,
            'waktu_masuk' => $waktu_masuk,
            'waktu_pulang' => $waktu_pulang,
            'status_masuk' => $inEpresence->is_approve === 'true' ? 'APPROVE' : 'REJECT',
            'status_pulang' => $outEpresence->is_approve === 'true' ? 'APPROVE' : 'REJECT',
        ];

        return response()
            ->json(['message' => 'Success add data', 'data' => [$dat, $dat2]]);
    }
}
