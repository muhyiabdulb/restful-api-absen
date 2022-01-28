<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Epresence;

class SupervisorController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        if($user['npp_supervisor'] !== null) {
            return response()
                ->json(['message' => 'Sorry you are not a supervisor :)']);
        }

        return response()
            ->json(['message' => 'Success get data', 'data' => $user]);
    }

    public function addUser(Request $request)
    {   
        $user = auth()->user();

        if($user['npp_supervisor'] !== null) {
            return response()
                ->json(['message' => 'Sorry you are not a supervisor :)']);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'npp' => 'required|min:5|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'npp' => $request->npp,
            'npp_supervisor' => auth()->user()->npp,
            'password' => bcrypt($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Success add data', 'data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }
    
    public function getUser()
    {
        $user = auth()->user();

        if($user['npp_supervisor'] !== null) {
            return response()
                ->json(['message' => 'Sorry you are not a supervisor :)']);
        }
        
        $users = User::where('npp_supervisor', $user->npp)->get();
        return response()
            ->json(['message' => 'Success get data', 'data' => $users]);
    }

    public function approveUser($id)
    {
        $user = auth()->user();
        // return $user;
        if($user['npp_supervisor'] !== null) {
            return response()
                ->json(['message' => 'Sorry you are not a supervisor :)']);
        }

        $data = Epresence::where('id', $id)->with('user')
                                            ->whereHas('user', function($q) use($user) {
                                                $q->where('npp_supervisor', $user->npp);
                                            })->first();
        if(empty($data)) {
            return response()
                ->json(['message' => "Sorry this is not your user, so you can't edit :)"]);
        } else {
            $data->is_approve = 'true';
            $data->save();

            return response()
                ->json(['message' => 'Success update data']);
        }
    }
}