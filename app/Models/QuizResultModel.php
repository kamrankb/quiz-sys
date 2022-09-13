<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class QuizResultModel extends Model
{
    use HasFactory,HasRoles,SoftDeletes;
    
    protected $table = 'quiz_result';

    public function student(){
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function quiz(){
        return $this->belongsTo(QuizModel::class, 'quiz_id', 'id');
    }

    public function quizAssigned(){
        return $this->belongsTo(QuizStudentModel::class, 'quiz_assign_id', 'id');
    }
}
