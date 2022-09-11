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

    public function subject(){
        return $this->belongsTo(Subjects::class, 'subject_id', 'id');
    }
}
