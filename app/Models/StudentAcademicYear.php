<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','academic_id','class_id','roll_number','fee','section_id'];

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function academic()
    {
       return $this->belongsTo(Academic::class);
    }
    public function class()
    {
       return $this->belongsTo(MyClass::class);
    }
}
