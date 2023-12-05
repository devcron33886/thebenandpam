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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('invitation_code')->unique();
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->string('number_of_guests');
            $table->boolean('status')->default(false);
            $table->string('seat_side');
            $table->string('table_number')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // <-- This will add a deleted_at field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
