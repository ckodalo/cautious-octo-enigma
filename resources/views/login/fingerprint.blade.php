<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4">The process to log in with your fingerprint has commenced...</p>
                <div id="feedback"></div>
            </div>
        </div>
    </div>

    <script type="module">
        import Webpass from "https://cdn.jsdelivr.net/npm/@laragear/webpass@1/dist/webpass.mjs";

        (async () => {
            try {
                if (Webpass.isUnsupported()) {
                    alert("Your browser doesn't support WebAuthn.");
                    window.location.replace("/login");
                }
                
                
                const { success } = await Webpass.attest("/webauthn/login/options", "/webauthn/login");
                if (success) {
                    window.location.replace("/dashboard");
                } else {
                    document.getElementById('feedback').innerText = "Fingerprint authentication failed. Please try again.";
                }
            } catch (error) {
                console.error("Error:", error);
                document.getElementById('feedback').innerText = "An error occurred. Please try again later.";
            }
        })();
    </script>
</x-guest-layout>
