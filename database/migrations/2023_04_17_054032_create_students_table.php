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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('last_name',100);
            $table->integer('age');
            $table->string('email',70);
            $table->foreign('course_id')
            ->references('id')
            ->on('courses')        
            ->onUpdate('cascade')->onDelete('restrict');            
            $table->timestamps();
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