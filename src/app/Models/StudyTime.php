<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyTime extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'time',
        'language_id',
        'content_id',
        'created_at',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
