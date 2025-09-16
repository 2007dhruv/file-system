<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    /**
     * Get the user that owns the folder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all files in this folder
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
