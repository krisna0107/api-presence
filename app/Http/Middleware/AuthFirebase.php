<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;

class AuthFirebase
{
    private $auth, $users;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->hasHeader('Authorization')) {
            return response()->json('Authorization Header not found', 401);
        }

        $token = $request->bearerToken();

        if($request->header('Authorization') == null || $token == null) {
            return response()->json('No token provided', 401);
        }

        $validation = $this->verifyToken($token);

        if ($validation !== true) 
        {
            return $validation;
        }

        return $next($request);
    }

    public function verifyToken($token)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($token);
        } catch (InvalidToken $e) {
            return response()->json([
                "error" => "AUTH01",
                "message" => "The token is invalid: ".$e->getMessage()
            ], 401);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                "error" => "AUTH02",
                "message" => "The token could not be parsed: ".$e->getMessage()
            ], 400);
        }
        return true;
    }

    public static function setUsersData($users)
    {
        $this->users = $users;
    }

    public static function getUsersData()
    {
        return $this->users;
    }
}
