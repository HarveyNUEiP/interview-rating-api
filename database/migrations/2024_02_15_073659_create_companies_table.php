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
        Schema::create('companies', function (Blueprint $table) {
            $table->id()->comment('Company ID');
            $table->string('name')->unique()->comment('Company name');
            $table->string('address')->comment('Company address');
            $table->string('phone_number')->comment('Company\'s phone number');
            $table->string('principal')->comment('Person in charge of the company');
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
        Schema::dropIfExists('companies');
    }
};
