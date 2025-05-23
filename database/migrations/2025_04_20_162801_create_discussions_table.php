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
      Schema::create('discussions', function (Blueprint $table) {
        $table->id();
        $table->string('ticket_code');
        $table->unsignedBigInteger('user_id');
        $table->text('message');
        $table->timestamps();

        $table->foreign('ticket_code')->references('ticket_code')->on('tickets')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
