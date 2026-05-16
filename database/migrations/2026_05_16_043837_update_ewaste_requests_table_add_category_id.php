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
        Schema::table('ewaste_requests', function (Blueprint $table) {
            // Tambah kolom category_id setelah user_id
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
            
            // Ubah kolom kategori jadi nullable (untuk backward compatibility)
            $table->string('kategori')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ewaste_requests', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('kategori')->nullable(false)->change();
        });
    }
};
