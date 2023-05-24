<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['class_id','teacher_id','name','code','slug','s_type','class_time','min','max'];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
}
