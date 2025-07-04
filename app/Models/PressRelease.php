<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PressRelease extends Model
{
    protected $fillable = [
        'title',
        'content',
        'status',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'excerpt',
        'formatted_published_at',
        'is_published',
    ];

    protected static function booted()
    {
        static::creating(function ($pressRelease) {
            $pressRelease->slug = Str::slug($pressRelease->title) . '-' . Str::random(5);
        });

        static::updating(function ($pressRelease) {
            if ($pressRelease->isDirty('title')) {
                $pressRelease->slug = Str::slug($pressRelease->title) . '-' . Str::random(5);
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->published()
            ->where('published_at', '>=', now()->subDays($days));
    }

    // Accessors
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 200);
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('F j, Y') : null;
    }

    public function getIsPublishedAttribute()
    {
        return $this->status === 'published' && $this->published_at && $this->published_at <= now();
    }

    // Methods
    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now()
        ]);
    }

    public function unpublish()
    {
        $this->update([
            'status' => 'draft',
            'published_at' => null
        ]);
    }

    public function archive()
    {
        $this->update([
            'status' => 'archived'
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
