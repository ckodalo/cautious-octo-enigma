<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Fingerprint Authentication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4">The process to register your fingerprint has commenced...</p>
                <div id="user-id" data-user-id="{{ auth()->id() }}"></div>
                <div id="feedback"></div>
            </div>
        </div>
    </div>

    <script>
        // Fetch registration options
        const fetchOptions = async () => {
            try {
                const response = await fetch("/webauthn/register/options", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                    }
                });
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.includes("application/json")) {
                    const options = await response.json();
                    console.log("Registration options:", options);

                    // Convert challenge property to ArrayBuffer
                    const challengeArrayBuffer = base64urlDecode(options.challenge);
                    options.challenge = challengeArrayBuffer;

                    // Convert user.id property to ArrayBuffer
                    const userIdArrayBuffer = base64urlDecode(options.user.id);
                    options.user.id = userIdArrayBuffer;

                    return options;
                } else {
                    const text = await response.text();
                    console.log("Response content:", text);
                    throw new Error("Response is not valid JSON");
                }
            } catch (error) {
                console.error("Error fetching registration options:", error);
                throw error;
            }
        };

        // Function to decode base64url-encoded string to ArrayBuffer
        const base64urlDecode = (str) => {
            const padding = '='.repeat((4 - str.length % 4) % 4);
            const base64 = (str + padding).replace(/-/g, '+').replace(/_/g, '/');
            const rawData = atob(base64);
            const buffer = new ArrayBuffer(rawData.length);
            const view = new Uint8Array(buffer);
            for (let i = 0; i < rawData.length; ++i) {
                view[i] = rawData.charCodeAt(i);
            }
            return buffer;
        };

        const base64urlEncode = (str) => {
            return btoa(String.fromCharCode.apply(null, new Uint8Array(str)))
                .replace(/\+/g, '-')
                .replace(/\//g, '_')
                .replace(/=/g, '');
        };

        const userIdElement = document.getElementById('user-id');
        const userId = userIdElement ? userIdElement.dataset.userId : null;

        const registerDevice = async (credential, userId) => {
            try {
                const { id, rawId, response: credentialResponse, type } = credential;

                console.log("userId is :", userId);

                const data = {
                    user_id: userId,
                    credential_id: id,
                    raw_id: base64urlEncode(rawId),
                    response: {
                        clientDataJSON: base64urlEncode(credentialResponse.clientDataJSON),
                        attestationObject: base64urlEncode(credentialResponse.attestationObject)
                    },
                    type
                };

                const registrationResponse = await fetch("/webauthn/register", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                });

                if (registrationResponse.ok) {
                    console.log("Device registration successful");
                } else {
                    throw new Error("Failed to register device");
                }
            } catch (error) {
                console.error("Error registering device:", error);
                // Handle error
            }
        };

        const registerFingerprint = async () => {
            try {

                const options = await fetchOptions();

                const credentialCreationOptions = {
                    publicKey: options
                };

                // ceremony to try and creare a public key credential
                const credential = await navigator.credentials.create(credentialCreationOptions);

                console.log("Fingerprint registration successful:", credential);

                await registerDevice(credential, userId);

                window.location.href = "/chirps";

            } catch (error) {
                console.error("Error registering fingerprint:", error);
            }
        };

        registerFingerprint();
    </script>

</x-app-layout>
