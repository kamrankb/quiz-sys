<?php

namespace App\Models;

use App\Models\QuizModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class QuizStudentModel extends Model
{
    use HasFactory,HasRoles,SoftDeletes;
    
    protected $table = 'quiz_student';

    public function student(){
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function quiz(){
        return $this->belongsTo(QuizModel::class, 'quiz_id', 'id');
    }
}
