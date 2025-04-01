<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Student extends Authenticatable
{
    use SoftDeletes;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'unilogin_user',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'student_id')->latest();
    }

    public function commentedOn()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function profilePicture()
    {
        return $this->hasOne(ProfilePicture::class, 'student_id', 'id');
    }

    public function usersNotCommentedOn()
    {
        $commentedUserIds = $this->commentedOn()->pluck('student_id')->toArray();
        return Student::whereNotIn('id', $commentedUserIds)
            ->where('id', '!=', $this->id)
            ->with('profilePicture')
            ->get();
    }
}
