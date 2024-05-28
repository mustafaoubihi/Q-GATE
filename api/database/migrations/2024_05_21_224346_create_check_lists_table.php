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
        Schema::create('check_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Add the user_id column
            $table->string('problem');
            $table->string('zone');
            $table->string('post');
            $table->boolean('isChecked')->default(false);
            $table->boolean('result')->nullable();
            $table->string('motif')->nullable();
            $table->integer('nbProblems')->default(0);
            $table->string('valideImgUrl');
            $table->string('notValideImgUrl');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('check_lists', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint
        });
        Schema::dropIfExists('check_lists');
    }
};
