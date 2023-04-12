<?php

namespace Database\Seeders;

use App\Models\Academic;
use App\Models\Medium;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Medium::create(['name'=>'Hindi','code'=>001]);
        $user = User::create(['name'=>'Narendra Singh Raghuwanshi','email'=>'nr9557@gmail.com','password'=>\Hash::make('Zarenta@321')]);
        $user->assignRole('admin');
        $user2 = User::create(['name'=>'Rajesh Kushwah','email'=>'rajcomgrp@gmail.com','password'=>\Hash::make('marks@321')]);
        $user2->assignRole('admin');
        Academic::create(['year'=>date('Y'),'year_range'=>Carbon::today()->format('Y').'-'.Carbon::today()->addYear()->format('Y'),'selected'=>'YES']);
    }
}
