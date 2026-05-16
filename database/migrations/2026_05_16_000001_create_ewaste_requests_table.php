<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ewaste_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mitra_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('kategori');
            $table->decimal('berat', 8, 2);
            $table->text('alamat');
            $table->text('catatan')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['menunggu', 'diambil', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ewaste_requests');
    }
};
