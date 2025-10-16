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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->dateTime('date');
            $table->decimal('ticket_price', 10, 2)->default(0);
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('tickets_sold')->default(0); //?

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
