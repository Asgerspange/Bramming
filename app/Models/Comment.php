<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Comment extends Model
{
    use SoftDeletes;
    protected $fillable = ['comment', 'student_id', 'user_id', 'created_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
