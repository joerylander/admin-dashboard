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
        Schema::create('recurring_entries', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('category');
            $table->string('description');
            $table->unsignedBigInteger('amount'); // Minor units (öre)
            $table->string('currency', 3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_entries');
    }
};
