<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory,HasRoles,SoftDeletes;

    public function service()
    {
        return $this->hasMany(Service::class, 'id', 'service_id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
