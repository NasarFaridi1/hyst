<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GoogleDriveService
{
    protected $drive;

    public function __construct()
    {
        $client = new Client();

        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));
        $client->refreshToken(config('google.refresh_token'));

        // dd($client);

        $this->drive = new Drive($client);
    }

    // public function upload($file)
    // {
    //     $fileMetadata = new DriveFile([
    //         'name' => time().'_'.$file->getClientOriginalName(),
    //         'parents' => [config('google.folder_id')],
    //     ]);

    //     $uploadedFile = $this->drive->files->create(
    //         $fileMetadata,
    //         [
    //             'data' => file_get_contents($file->getRealPath()),
    //             'mimeType' => $file->getMimeType(),
    //             'uploadType' => 'multipart',
    //             'fields' => 'id,name'
    //         ]
    //     );

    //     $permission = new \Google\Service\Drive\Permission([
    //         'type' => 'anyone',
    //         'role' => 'reader',
    //     ]);

    //     $this->drive->permissions->create(
    //         $uploadedFile->id,
    //         $permission
    //     );

    //     return $uploadedFile;
    // }

    public function upload($file)
    {
        $originalName = method_exists($file, 'getClientOriginalName')
            ? $file->getClientOriginalName()
            : basename($file->getRealPath());

        $fileMetadata = new DriveFile([
            'name' => time().'_'.$originalName,
            'parents' => [config('google.folder_id')],
        ]);

        $uploadedFile = $this->drive->files->create(
            $fileMetadata,
            [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id,name'
            ]
        );

        $permission = new \Google\Service\Drive\Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);

        $this->drive->permissions->create(
            $uploadedFile->id,
            $permission
        );

        return $uploadedFile;
    }

    public function getPublicUrl($fileId)
    {
        return "https://drive.google.com/uc?id=".$fileId;
    }

    public function delete($fileId)
    {
        return $this->drive->files->delete($fileId);
    }
}