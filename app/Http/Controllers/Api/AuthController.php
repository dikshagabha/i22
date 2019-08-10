<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CommonRepository;
use JWTAuth;
use Carbon\Carbon;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {   
        $request->validate([
            'username'=>'bail|required|string|min:1|max:25',
            'password'=>'required'
        ]);


        // get the user email
        $credentials = $request->only('username', 'password');
        $credentials['role'] = 1;

        //dd(JWTAuth::attempt($credentials));
        // attempt to verify the credentials and a token for the user
        if ($token = JWTAuth::attempt($credentials,  ['exp' => Carbon::now()->addDays(7)->timestamp])) {
            // token generated successfully
            //$response = compact('token');
            // find the user
            $user = Auth::user();

            $user->device_token = $request->input('device_id', '');
            $user->last_login = Carbon::now();
            $user->save(); // save the user (update the device token)

            //$common = new CommonRepositary;
            CommonRepository::getManageToken($token, $user->id); // save the token in the database

            $response['http_status'] = 200;
            $response['details'] = ['token'=>$token, 'info'=>$user];

            $response['message'] = 'Success';
        } else {
            
            $response['message'] = 'Please enter valid credentials';
            $response['http_status'] = 400;
        }

        return response()->json($response, $response['http_status']);

    }
}
