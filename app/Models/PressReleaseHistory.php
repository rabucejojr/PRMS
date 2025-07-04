<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressReleaseHistory extends Model
{
    protected $fillable = [
        'press_release_id',
        'user_id',
        'changes',
    ];

    public function pressRelease()
    {
        return $this->belongsTo(PressRelease::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
