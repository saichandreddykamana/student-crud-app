<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
         * Run the migrations.
         * Creates a 'students' table in the database with columns for student information.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->enum('title', ['Dr', 'Mr', 'Mrs', 'Ms', 'Mx', 'Professor']) -> nullable();
            $table->string('student_id', 8)->unique();
            $table->string('forename_1', 100) -> nullable();
            $table->string('forename_2', 100) -> nullable();
            $table->string('surname', 100);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('date_of_birth');
            $table->string('username', 6)->unique();
            $table->string('email', 255)->unique();
            $table->timestamps();
            $table->primary('student_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
