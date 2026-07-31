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
        Schema::create('schools', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('school_code', 50)->unique()->nullable();

            // Relational mapping back to the parent jurisdiction
            $table->ulid('district_id')
                ->constrained()
                ->onDelete('cascade'); // Purges schools if a district is removed

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
