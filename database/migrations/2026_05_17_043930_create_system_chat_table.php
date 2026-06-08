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
        Schema::create('system_chat', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('user_type')->default(2)->comment('1: Admin, 2: Customer');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_chat');
    }
};
