<?php

namespace App\Http\Controllers\WebAuthn;
use Laragear\WebAuthn\Http\Requests\AttestationRequest;
use Laragear\WebAuthn\Http\Requests\AttestedRequest;
use Illuminate\Http\Request;
use App\Models\PublicKeyCredential;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class AttestationController {
   
    public function createChallenge(AttestationRequest $request)
    {
        Log::info('Reached the createChallenge method in the AttestationController.');
        //return $request->toCreate();
        return $request->fastRegistration()->toCreate();
    }

        public function register(Request $request)
    {
        //$attestation->save();

        Log::info('Reached the register method in the register controller.');
        
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'user_id' => 'required|string',
                'credential_id' => 'required|string',
                'raw_id' => 'required|string',
                'response.clientDataJSON' => 'required|string',
                'response.attestationObject' => 'required|string',
                'type' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            // Log validation failure
            Log::error('Validation failed for PublicKeyCredential data.', ['errors' => $e->errors()]);

            // Re-throw the exception to handle it further
            throw $e;
        }

        // Log validation success
        Log::info('Validation passed for PublicKeyCredential data.', ['validated_data' => $validatedData]);

        // Create a new instance of PublicKeyCredential model and fill it with validated data
        $publicKeyCredential = new PublicKeyCredential();
        $publicKeyCredential->user_id = $validatedData['user_id'];
        $publicKeyCredential->credential_id = $validatedData['credential_id'];
        $publicKeyCredential->raw_id = $validatedData['raw_id'];
        $publicKeyCredential->client_data_json = $validatedData['response']['clientDataJSON'];
        $publicKeyCredential->attestation_object = $validatedData['response']['attestationObject'];
        $publicKeyCredential->type = $validatedData['type'];

        // Save the PublicKeyCredential instance to the database
        $publicKeyCredential->save();

        // Log successful data insertion
        Log::info('PublicKeyCredential data stored successfully.', ['stored_data' => $publicKeyCredential->toArray()]);

        // You may return a success response or redirect the user to a success page
        return response()->json(['message' => 'PublicKeyCredential saved successfully']);
    }

    public function registerDevice(AttestationRequest $request)
    {
        return $request->userless()->toCreate();
    }


}