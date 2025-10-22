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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('family_card_number'); // No. KK
            $table->string('head_of_family'); // Nama Kepala Keluarga
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->text('address');
            $table->boolean('has_received_aid')->default(false); // Status penerimaan bansos

            // Foreign keys
            $table->foreignId('department_id')->constrained();
            $table->foreignId('kabupaten_id')->nullable()->constrained('regions');
            $table->foreignId('kecamatan_id')->nullable()->constrained('regions');
            $table->foreignId('desa_id')->nullable()->constrained('regions');
            $table->foreignId('user_id')->nullable()->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
