<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserBankAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserBankAccountContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('api:auth', ['except' => ['add_user_bank_account', 'update_bank', 'delete_bank']]);
    }

    // public function index(){
    //     $data = Bank::all();
    // }


    
    public function add_user_bank_account()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'user_id' => 'required',
                'userData' => 'required',
                'bankData' => 'required',
                'branch' => 'required',
                'account_name' => 'required',
                'account_number' => 'required'
            ]
        );
        if ($validator->fails()) {
            // return response()->json($validator->messages());

            return response()->json([
                'status' => false,
                'error' => false,
                'message' => 'Error',
                'data' => null,
            ], 200);
        }

        $userbankaccount = Bank::create([
            'user_id' => request('user_id'),
            'userData' => request('userData'),
            'bankData' => request('bankData'),
            'branch' => request('branch'),
            'account_name' => request('account_name'),
            'account_number' => request('account_number')
        ]);

        if ($userbankaccount) {
            // return response()->json(['message' => 'Pendaftaran']);

            return response()->json([
                'status' => true,
                'error' => false,
                'message' => 'success',
                'data' => $userbankaccount,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => false,
                'message' => 'Error',
                'data' => null,
            ], 200);
        }
    }


    public function update_bank(request $Request, $id)
    {
        $validator = Validator::make(
            request()->all(),
            [
                'name' => 'required',
                'acronym' => 'required',
                'code' => 'required',
                'icon' => 'required',
                'status' => 'required',
                'createby' => 'required',
                'updateby' => 'required'
            ]
        );
        if ($validator->fails()) {
            // return response()->json($validator->messages());

            return response()->json([
                'status' => false,
                'error' => false,
                'message' => 'Error',
                'data' => null,
            ], 200);
        }

        $updatebank = Bank::find($id);
        $bank = $updatebank->update([
            'name' => request('name'),
            'acronym' => request('acronym'),
            'code' => request('code'),
            'icon' => request('icon'),
            'status' => request('status'),
            'createby' => request('createby'),
            'updateby' => request('updateby')
        ]);

        if ($bank) {
            // return response()->json(['message' => 'Pendaftaran']);

            return response()->json([
                'status' => true,
                'error' => false,
                'message' => 'success',
                'data' => $bank,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => false,
                'message' => 'Error',
                'data' => null,
            ], 200);
        }
    }

    public function delete_bank(request $Request, $id)
    {
        $deletebank = Bank::find($id);
        $bank = $deletebank->delete();

        if ($bank) {
            // return response()->json(['message' => 'Pendaftaran']);

            return response()->json([
                'status' => true,
                'error' => false,
                'message' => 'success',
                'data' => $bank,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => false,
                'message' => 'Error',
                'data' => null,
            ], 200);
        }
    }


    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
}
