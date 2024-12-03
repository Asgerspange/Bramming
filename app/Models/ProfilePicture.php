<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    protected $fillable = ['unilogin', 'picture'];
    public $table = 'profile_pictures';
    public $timestamps = false;
}
