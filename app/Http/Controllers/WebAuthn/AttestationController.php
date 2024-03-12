<?php

namespace App\Http\Controllers\WebAuthn;
use Laragear\WebAuthn\Http\Requests\AttestationRequest;
use Laragear\WebAuthn\Http\Requests\AttestedRequest;
use Illuminate\Support\Facades\Log;

class AttestationController {
   
    public function createChallenge(AttestationRequest $request)
    {
        Log::info('Reached the createChallenge method in the AttestationController.');
        //return $request->toCreate();
        return $request->fastRegistration()->toCreate();
    }

        public function register(AttestedRequest $attestation)
    {
        $attestation->save();
        
        return 'Now you can login without passwords!';
    }

    public function registerDevice(AttestationRequest $request)
    {
        return $request->userless()->toCreate();
    }


}