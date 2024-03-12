<?php

namespace App\Http\Controllers\WebAuthn;

use Laragear\WebAuthn\Http\Requests\AssertionRequest;
use Laragear\WebAuthn\Http\Requests\AssertedRequest;

class AssertionController {

    // public function createChallenge(AssertionRequest $request)
    // {
    //     $request->validate(['email' => 'sometimes|email']);

    //     return $request->toVerify($request->only('email'));
    // }

        public function createChallenge(AssertedRequest $request)
    {
        $user = $request->login();
        
        return $user ? response("Welcome back, $user->name!") : response('Something went wrong, try again!');
    }

}