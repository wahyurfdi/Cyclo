<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\ClientRepository;
use Lcobucci\JWT\Parser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getTokenDetail($bearerToken='')
    {
        if(empty($bearerToken)) return '';

        $tokenRepository = new TokenRepository();
	    $jwt = (new Parser())->parse($bearerToken);
	    $token = $tokenRepository->find($jwt->getClaim('jti'));

        return $token;
    }

    public function sendResponseSuccess($message='', $result=[], $code=200)
    {
        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'result' => $result
        ], $code);
    }

    public function sendResponseError($message='', $code=400)
    {
        return response()->json([
            'status' => 'FAIL',
            'message' => $message
        ], $code);
    }
}
