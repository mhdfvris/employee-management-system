<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activities()
    {
        return $this->hasMany(\App\Models\TaskActivity::class);
    }

    public function logActivity(string $action, array $meta = []): void
    {
        $this->activities()->create([
            'actor_id' => auth()->id(), // null if scheduler/CLI
            'action'   => $action,
            'meta'     => $meta ?: null,
        ]);
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\TaskReview::class);
    }
}
