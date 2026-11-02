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
        Schema::create('budget_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_month_id')->constrained()->cascadeOnDelete();
            // Which template the entry was created from; kept as null if the template is deleted
            $table->foreignId('recurring_entry_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->string('category');
            $table->string('description');
            $table->unsignedBigInteger('amount'); // Minor units (öre)
            $table->string('currency', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_entries');
    }
};
