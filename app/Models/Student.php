<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'student_id'; // 'student_id' is the primary key

    protected $fillable = [
        'title',
        'student_id',
        'forename_1',
        'forename_2',
        'surname',
        'gender',
        'date_of_birth',
        'username',
        'email',
    ];

    protected $casts = [
        'date_of_birth' => 'date', // 'date_of_birth' is cast to a date type
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_of_birth'];
}