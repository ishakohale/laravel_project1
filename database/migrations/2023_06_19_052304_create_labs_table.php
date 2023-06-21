<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
        // $table->string('StudentName');

        // $table->string('BookName');
        $table->foreignId('student_id')->constrained('students');
        $table->foreignId('book_id')->constrained('books');


        $table->date('Date');

        $table->timestamps();
        });
    }

    /**$table->foreignId('schedule_type_id')->constrained('schedule_types');






     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
