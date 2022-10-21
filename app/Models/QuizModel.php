<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class QuizModel extends Model
{
    use HasFactory,HasRoles,SoftDeletes;
    
    protected $table = 'quiz';
    protected $fillable = ['subject_id','name', 'questions', 'time', 'difficulty', 'other', 'created_by', 'status'];


    public function subject(){
        return $this->belongsTo(Subjects::class, 'subject_id', 'id');
    }

    public function qQuestions(){
        return $this->hasMany(QuizQuestionModel::class, 'quiz_id', 'id');
    }
}
