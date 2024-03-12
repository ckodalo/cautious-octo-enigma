<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                  
                </div>
            </div>
        </div>
    </div>   
    <!-- <script  type="module" >
        import Webpass from "https://cdn.jsdelivr.net/npm/@laragear/webpass@1/dist/webpass.mjs"
    try {
        console.log("Webpass:", Webpass);
        console.log("Type of Webpass:", typeof Webpass);

        (async () => {
            if (Webpass.isUnsupported()) {
                alert("Your browser doesn't support WebAuthn.");
                return;
            }
            
            const { success } = await Webpass.attest("/webauthn/register/options", "/webauthn/register");
            
        console.log("Success:", success);


            if (success) {
                window.location.replace("/dashboard");
            }
        })();
    } catch (error) {
        console.error("Error:", error);
    }
</script> -->

</x-app-layout>
