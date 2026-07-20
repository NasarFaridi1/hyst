<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'logs_db';

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'action',
        'module',
        'reference_id',
        'description',
        'ip_address',
        'payload',
        'response',
        'status',
    ];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
    ];


    public static function log(
        $module,
        $action,
        $description,
        $referenceId = null,
        $payload = [],
        $response = [],
        $status = 'success'
    ) {
        return self::create([
            'user_id'      => auth()->id(),
            'module'       => $module,
            'action'       => $action,
            'reference_id' => $referenceId,
            'description'  => $description,
            'ip_address'   => request()->ip(),
            'payload'      => $payload,
            'response'     => $response,
            'status'       => $status,
        ]);
    }
}