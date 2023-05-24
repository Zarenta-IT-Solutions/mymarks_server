<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('current_academic_year_id')->nullable();
            $table->unsignedBigInteger('medium_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('address')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->timestamp('date_of_join')->nullable();
            $table->enum('gender',['male','female','other'])->default('male');
            $table->enum('blood_group',['A-','A+','B-','B+','AB-','AB+','O-','O+'])->default('B+');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->float('salary')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('cast')->nullable();
            $table->string('family_id')->nullable();
            $table->string('sssm_id')->nullable();
            $table->string('sambal')->nullable();
            $table->enum('rte',['yes','no'])->default('no');
            $table->string('rte_number')->nullable();
            $table->string('enrollment')->nullable();
            $table->string('scholar')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_account')->nullable();
            $table->text('about')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('medium_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('current_academic_year_id')->references('id')->on('academics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
