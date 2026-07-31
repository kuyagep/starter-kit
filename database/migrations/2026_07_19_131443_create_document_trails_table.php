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
        Schema::create('document_trails', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // Link directly to the document being tracked
            $table->ulid('document_id')->constrained()->onDelete('cascade');

            // Who took the action and where are they located?
            $table->ulid('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->ulid('office_id')->constrained()->onDelete('restrict');

            // Log details
            $table->string('action'); // e.g., 'Drafted', 'Transmitted', 'Received', 'Filed'
            $table->text('remarks')->nullable(); // Optional routing notes or reasons for deferral

            $table->timestamps(); // creates created_at (our exact timestamp marker)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_trails');
    }
};
