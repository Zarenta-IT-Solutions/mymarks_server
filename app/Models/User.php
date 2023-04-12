<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Subject;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','password','api_token','address','mobile','date_of_birth','current_academic_year_id','gender','about','avatar','address','blood_group','country_id','state_id','city_id','mother_name','father_name','aadhar','cast','family_id','sssm_id','rte','rte_number','roll_number','enrollment','scholar','medium_id','bank_name','bank_ifsc','bank_account','sambal'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function myClass()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }
    public function academic()
    {
        return $this->belongsTo(Academic::class,'id','current_academic_year_id');
    }
    public function academicYear()
    {
        return $this->hasOne(StudentAcademicYear::class);
    }

    public function subjects()
    {
         return $this->hasManyThrough(StudentAcademicYear::class, subject::class,'class_id','user_id','academic_year_id','class_id');
        //  echo $q; exit;
    }

    public function academicYearWithId($id)
    {
        return $this->hasOne(StudentAcademicYear::class)->where('academic_id',$id);
    }
    public function medium()
    {
        return $this->belongsTo(Medium::class);
    }
    public function getAvatarAttribute($avatar)
    {
        if(\request()->session()->has('slug') && $avatar){
            return Storage::url(\request()->session()->get('slug').'/'.$avatar);
        }
        if($avatar){ return Storage::url($avatar); }
        else { return Storage::url('avatar/user.png'); }
    }
    public function getDateOfBirthAttribute($date)
    {
        if($date!=null) {
            return $date ? Carbon::parse($date)->format('d-m-Y') : null;
        }
    }



}
