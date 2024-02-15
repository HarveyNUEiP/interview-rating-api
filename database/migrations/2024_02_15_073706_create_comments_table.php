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
        Schema::create('comments', function (Blueprint $table) {
            $table->id()->comment('Comment ID');
            $table->foreignId('company_id')->constrained()->comment('Company ID');
            $table->foreignId('user_id')->constrained()->comment('User ID');
            $table->char('interview_review', 255)->comment('Interview review');
            $table->integer('rating')->comment('Rate of the interview');
            $table->dateTime('deleted_at')->nullable()->comment('Comment soft deleted time');
            $table->tinyInteger('status')->default(1)->comment('1: active, 0: inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
