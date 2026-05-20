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
    Schema::table('profiles', function (Blueprint $table) {
        $table->string('kepala_nama')->nullable();
        $table->string('kepala_telp')->nullable();
        $table->string('hoc_nama')->nullable();
        $table->string('hoc_telp')->nullable();
        $table->string('ppk_nama')->nullable();
        $table->string('ppk_telp')->nullable();
        $table->string('bpkrt_nama')->nullable();
        $table->string('bpkrt_telp')->nullable();
    });
   }

   public function down(): void
   {
    Schema::table('profiles', function (Blueprint $table) {
        $table->dropColumn([
            'kepala_nama',
            'kepala_telp',
            'hoc_nama',
            'hoc_telp',
            'ppk_nama',
            'ppk_telp',
            'bpkrt_nama',
            'bpkrt_telp'
        ]);
    });
   }
};
