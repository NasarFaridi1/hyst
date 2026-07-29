<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    //
    public function index()
    {
        return view('admin.google-drive.index');
    }

    private function client()
    {
        $client = new Client();

        $client->setAuthConfig(
            storage_path('app/oauth-client.json')
        );

        $client->setRedirectUri(
            'https://hyst.uk/oauth2callback'
        );

        $client->addScope(Drive::DRIVE);

        $client->setAccessType('offline');

        $client->setPrompt('consent');

        return $client;
    }

    public function generateUrl()
    {
        $url = $this->client()->createAuthUrl();

        return back()->with(
            'auth_url',
            $url
        );
    }



    public function generateToken(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        try {

            $client = new Client();

            $client->setAuthConfig(
                storage_path('app/oauth-client.json')
            );

            $client->setRedirectUri('https://hyst.uk/oauth2callback');

            $client->addScope(Drive::DRIVE);

            $client->setAccessType('offline');

            $client->setPrompt('consent');

            $token = $client->fetchAccessTokenWithAuthCode(
                trim($request->code)
            );

            // Google returned an error
            if (isset($token['error'])) {

                return back()->with([
                    'error' => $token['error_description'] ?? $token['error'],
                    'token' => $token,
                ]);

            }

            // Refresh token is required
            if (empty($token['refresh_token'])) {

                return back()->with([
                    'error' => 'Refresh token was not returned. Make sure you authorize using prompt=consent and access_type=offline.',
                    'token' => $token,
                ]);

            }

            // Save only refresh token
            Storage::put(
                'google-drive-token.json',
                json_encode([
                    'refresh_token' => $token['refresh_token'],
                    'expires_at' => now()
                        ->addSeconds($token['refresh_token_expires_in'] ?? 0)
                        ->toDateTimeString(),
                ], JSON_PRETTY_PRINT)
            );

            return back()->with([
                'success' => 'Refresh token generated and saved successfully.',
                'refresh_token' => $token['refresh_token'],
                'token' => $token,
            ]);

        } catch (\Exception $e) {

            return back()->with([
                'error' => $e->getMessage(),
            ]);

        }
    }
}