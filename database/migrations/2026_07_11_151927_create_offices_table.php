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
        Schema::create('offices', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->unique(); // e.g., "Digos City NHS", "District I", "Records Section"
            $table->string('code')->nullable()->unique(); // e.g., "DC-NHS", "DIST-1", "REC-DIV"
            $table->string('building_location')->nullable();
            $table->enum('office_type', ['Division Office', 'District', 'School'])->default('Division Office');
            // Conditional tracking metadata
            $table->string('school_id')->nullable()->unique(); // Active only if office_type is 'School'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
