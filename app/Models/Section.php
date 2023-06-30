<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Section extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','class_id','teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
    public function my_class()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }

}
