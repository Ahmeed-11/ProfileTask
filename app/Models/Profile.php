<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Accept All Fields
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/profile_images/' . $this->image) : null;
    }
}
