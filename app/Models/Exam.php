<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['class_id','academic_year_id','name','subject_data','template','excel','excelHeadings','excelMapping'];

    public function my_class()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }
    public function academic_year()
    {
        return $this->belongsTo(Academic::class,'academic_year_id');
    }
    
    protected $casts = [
        'subject_data'=>'array',
        'excelHeadings'=>'array',
        'excelMapping'=>'array',
    ];
}
