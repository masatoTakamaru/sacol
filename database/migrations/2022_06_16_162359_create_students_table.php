<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('registered_date');
            $table->boolean('expired_flag')->default(null);
            $table->date('expired_date')->nullable();
            $table->integer('student_group')->nullable();
            $table->string('family_name');
            $table->string('given_name');
            $table->string('family_name_kana');
            $table->string('given_name_kana');
            $table->string('gender');
            $table->integer('grade');
            $table->date('birth_date')->nullable();
            $table->string('school_attended')->nullable();
            $table->string('family_group')->nullable();
            $table->string('guardian_family_name')->nullable();
            $table->string('guardian_given_name')->nullable();
            $table->string('guardian_family_name_kana')->nullable();
            $table->string('guardian_given_name_kana')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone1_relationship')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone2_relationship')->nullable();
            $table->string('email')->nullable();
            $table->string('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
