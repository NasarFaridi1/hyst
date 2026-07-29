@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto p-8">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Google Drive Token Generator
        </h1>

        <p class="text-gray-500 mt-2">
            Generate a Google Drive Refresh Token for Hyst.
        </p>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">

        <h2 class="text-lg font-semibold text-blue-800 mb-4">
            📋 Instructions
        </h2>

        <ul class="list-disc pl-6 space-y-3 text-gray-700">

            <li>
                Click <strong>"Generate Authorization URL"</strong> to generate the Google OAuth authorization link.
            </li>

            <li>
                Click <strong>"Open Google Authorization"</strong> (or copy the URL and open it in your browser).
            </li>

            <li>
                Sign in using the Google account that will be used for storing application files in Google Drive.
            </li>

            <li>
                Click <strong>Allow</strong> when Google asks for permission to access your Google Drive.
            </li>

            <li>
                After successful authorization, Google will redirect you to:
                <br>
                <code class="bg-gray-100 px-2 py-1 rounded text-sm">
                    https://hyst.uk/oauth2callback?code=xxxxxxxxxxxx
                </code>
            </li>

            <li>
                Copy <strong>only the value of the <code>code</code> parameter</strong>.
                <br>
                Example:
                <br>
                <code class="bg-gray-100 px-2 py-1 rounded text-sm break-all">
                    https://hyst.uk/oauth2callback?code=4/0AXEQxIAbCdEf123456789&scope=https://www.googleapis.com/auth/drive
                </code>
                <br><br>
                Copy only:
                <br>
                <code class="bg-green-100 px-2 py-1 rounded text-sm">
                    4/0AXEQxIAbCdEf123456789
                </code>
            </li>

            <li>
                Paste the copied authorization code into the
                <strong>"Authorization Code"</strong> textbox.
            </li>

            <li>
                Click <strong>"Generate Refresh Token"</strong>.
            </li>

            <li>
                The application will:
                <ul class="list-disc pl-6 mt-2 space-y-1">
                    <li>Generate the Google Refresh Token.</li>
                    <li>Automatically save it to <code>storage/app/google-drive-token.json</code>.</li>
                    <li>Display the complete Google API response.</li>
                </ul>
            </li>

            <li>
                If the token is generated successfully, Google Drive uploads are ready to use immediately.
            </li>

            <li>
                If the OAuth Consent Screen is still in <strong>Testing</strong> mode, the refresh token expires after approximately <strong>7 days</strong>. Once the OAuth app is published to <strong>Production</strong>, refresh tokens generally do not expire automatically.
            </li>

        </ul>

    </div>

    

    {{-- STEP 1 --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">

        <h2 class="text-lg font-semibold mb-4">
            Step 1 - Generate Authorization URL
        </h2>

        <form
            method="POST"
            action="{{ route('admin.google-drive.generate-url') }}">

            @csrf

            <button
                class="bg-[#C25A2A] hover:bg-blue-700 text-white px-6 py-2 rounded">
                Generate Authorization URL
            </button>

        </form>

        @if(session('auth_url'))

            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Authorization URL
                </label>

                <textarea
                    readonly
                    rows="6"
                    onclick="this.select()"
                    class="w-full border rounded-lg p-3 bg-gray-50 text-sm">{{ session('auth_url') }}</textarea>

            </div>

            <div class="mt-4 flex gap-3">

                <a
                    href="{{ session('auth_url') }}"
                    target="_blank"
                    class="bg-[#C25A2A] hover:bg-green-700 text-white px-5 py-2 rounded">

                    Open Google Authorization

                </a>

                <button
                    type="button"
                    onclick="copyText('{{ session('auth_url') }}')"
                    class="bg-[#C25A2A] hover:bg-gray-800 text-white px-5 py-2 rounded">

                    Copy URL

                </button>

            </div>

        @endif

    </div>

    {{-- STEP 2 --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">

        <h2 class="text-lg font-semibold mb-4">

            Step 2 - Paste Authorization Code

        </h2>

        <form
            method="POST"
            action="{{ route('admin.google-drive.generate-token') }}">

            @csrf

            <label class="block mb-2 font-medium">

                Authorization Code

            </label>

            <textarea
                name="code"
                rows="5"
                required
                class="w-full border rounded-lg p-3"
                placeholder="Paste only the code returned by Google...">{{ old('code') }}</textarea>

            @error('code')

                <div class="text-red-600 mt-2">

                    {{ $message }}

                </div>

            @enderror

            <button
                class="mt-5 bg-[#C25A2A] hover:bg-indigo-700 text-white px-6 py-2 rounded">

                Generate Refresh Token

            </button>

        </form>

    </div>

    {{-- STEP 3 --}}
    @if(session('refresh_token'))

    <div class="bg-white shadow rounded-lg p-6 mb-8">

        <h2 class="text-lg font-semibold mb-4">

            Step 3 - Refresh Token

        </h2>

        <textarea
            readonly
            rows="4"
            onclick="this.select()"
            id="refreshToken"
            class="w-full border rounded-lg p-3 bg-gray-50">{{ session('refresh_token') }}</textarea>

        <button
            class="mt-4 bg-[#C25A2A] hover:bg-green-700 text-white px-5 py-2 rounded"
            onclick="copyRefreshToken()">

            Copy Refresh Token

        </button>

    </div>

    @endif

    {{-- STEP 4 --}}
    @if(session('token'))

    <div class="bg-white shadow rounded-lg p-6">

        <h2 class="text-lg font-semibold mb-4">

            Google Response

        </h2>

        <textarea
            readonly
            rows="18"
            onclick="this.select()"
            class="w-full border rounded-lg p-3 bg-gray-50 text-sm">{{ json_encode(session('token'), JSON_PRETTY_PRINT) }}</textarea>

    </div>

    @endif

</div>

<script>

    function copyRefreshToken(){

        let copyText = document.getElementById("refreshToken");

        copyText.select();

        copyText.setSelectionRange(0,99999);

        navigator.clipboard.writeText(copyText.value);

        alert("Refresh Token Copied");

    }

    function copyText(text){

        navigator.clipboard.writeText(text);

        alert("Authorization URL Copied");

    }

</script>

@endsection