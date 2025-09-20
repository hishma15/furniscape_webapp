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
        //
        Schema::dropIfExists('consultations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        $table->id();

        $table->foreignId('customer_id')->constrained('users')->onDelete('cascade'); // Customer
        $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // Admin who confirms
        $table->date('prefered_date');
        $table->string('prefered_time');
        $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
        $table->string('mode');
        $table->string('topic')->nullable();
        $table->text('description')->nullable();

        $table->timestamps();
    }
};
