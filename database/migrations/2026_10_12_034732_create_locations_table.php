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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            // Koordinat disimpan sebagai string agar presisi desimal terjaga
            // (kontrak openapi.yaml: Location.latitude/longitude bertipe string)
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->enum('type', ['baznas', 'upz', 'warga'])->default('upz');
            $table->text('description')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('opening_hours')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
