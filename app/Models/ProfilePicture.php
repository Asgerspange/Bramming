<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    protected $fillable = ['student_id', 'picture'];
    public $table = 'profile_pictures';
    public $timestamps = false;
}
