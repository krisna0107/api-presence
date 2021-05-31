<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;

class ValidasiController extends Controller
{

    private $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function validasi()
    {
        try {
            $verifiedIdToken = app('firebase.auth')->verifyIdToken($this->token);
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
        
        return $verifiedIdToken->claims()->get('sub');
    }
}
