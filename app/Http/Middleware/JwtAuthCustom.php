<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Model\Token;
class JwtAuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        try {
            // parse the token from the request and fetch the user
            // if the token is not in the request, token is invalid, token is expired it will throw an Exception form below line
            $user = JWTAuth::parseToken()->authenticate();

            // if we have an user
            if (!$user) {
                return response()->json([
                        'message' => 'Sorry, looks like you are logged in another device with the same user.',], 401);
            }

            // get the token from the request
            $token = JWTAuth::getToken();
            $token = Token::where(['user_id' => $user->id, 'token' => $token])->first();

            // check if that token exists in the database for the same user id
            if (!$token) {
                return response()->json([
                        'message' => 'Sorry, looks like you are logged in another device with the same user.',
                        ], 401);
            }

            
            return $next($request);
            
        } catch (TokenExpiredException $e) {
            
            return response()->json([
                    'message' => $e->getMessage(),], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                    'message' => $e->getMessage()], 401);
        } catch (JWTException $e) {
            return response()->json([
                    'message' => $e->getMessage()], 401);
        }
        return $next($request);
    }
}
