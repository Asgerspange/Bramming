<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'student_id', 'user_id', 'created_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
