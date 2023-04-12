<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marks extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['class_id','academic_year_id','exam_id','user_id','roll_number','percent','description','mark_data','calculate_data'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    protected $casts = [
        'mark_data'=>'array',
        'calculate_data'=>'array',
    ];

}
