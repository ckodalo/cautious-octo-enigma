<!-- register_complete.blade.php -->

<x-guest-layout>
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <h2 class="mb-6 text-lg font-medium text-gray-900">Registration Complete</h2>
            <p class="mb-6 text-gray-700">Do you want to add authentication with fingerprint?</p>
            <div class="flex items-center justify-between">
                <a href="{{ route('fingerprint.page') }}" class="inline-block w-1/2 py-2 text-center text-white bg-indigo-500 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Yes</a>
                <a href="{{ route('dashboard') }}" class="inline-block w-1/2 py-2 text-center text-white bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">No</a>
            </div>
        </div>
    </div>
</x-guest-layout>
