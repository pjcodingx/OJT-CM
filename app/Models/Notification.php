<?php

namespace App\Models;
use Illuminate\Support\Facades\Log;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //

    protected $fillable = [
        'user_id',
        'user_type',
        'title',
        'message',
        'is_read',
        'type',

    ];

    public static function createLimited(array $data)
{
    $limits = [
        'admin'   => 35,
        'faculty' => 20,
        'student' => 20,
        'company' => 25,
    ];

    $maxPerUser = $limits[$data['user_type']] ?? 15;

    $count = self::where('user_id', $data['user_id'])
        ->where('user_type', $data['user_type'])
        ->count();



    if ($count >= $maxPerUser) {
        Log::warning("Notification limit reached for {$data['user_type']} ID {$data['user_id']} — skipping creation.");
        return null;
    }

    return self::create($data);
}



}
