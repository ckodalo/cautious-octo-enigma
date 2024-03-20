<x-guest-layout>
    <form id="usernameForm">
        @csrf

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    const fetchOptions = async (username) => {
        try {
            const response = await fetch("/webauthn/login/options", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ username })
            });
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                const options = await response.json();
                console.log("Login options:", options); 
                
                // Convert challenge property to ArrayBuffer
                const challengeArrayBuffer = base64urlDecode(options.challenge);
                options.challenge = challengeArrayBuffer;

                return options;
            } else {
                const text = await response.text();
                console.log("Response content:", text);
                throw new Error("Response is not valid JSON");
            }
        } catch (error) {
            console.error("Error fetching login options:", error);
            throw error;
        }
    };

    const authenticateDevice = async (assertion) => {
        try {
            const response = await fetch("/webauthn/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(assertion)
            });

            if (response.ok) {
                console.log("Device authentication successful");
                console.log("device ref", response);
                window.location.href = "/chirps";
            } else {
                throw new Error("Failed to authenticate device");
            }
        } catch (error) {
            console.error("Error authenticating device:", error);
            
        }
    };

    const loginWithFingerprint = async (username) => {
        try {
            const options = await fetchOptions(username);

            const assertionCreationOptions = {
                publicKey: options
            };

            const assertion = await navigator.credentials.get(assertionCreationOptions);

            console.log("assertion for this user", assertion)

            await authenticateDevice(assertion);
        } catch (error) {
            console.error("Error during fingerprint authentication:", error);
            document.getElementById('feedback').innerText = "An error occurred. Please try again later.";
        }
    };

    document.getElementById('usernameForm').addEventListener('submit', async (event) => {
        event.preventDefault(); 
        const username = document.getElementById('username').value;
        console.log("Username:", username); 
        await loginWithFingerprint(username); 
    });

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
</script>