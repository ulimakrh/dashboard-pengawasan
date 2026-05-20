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
        Schema::create('satkers', function (Blueprint $table) {
       	 $table->id();
       	 $table->string('nama_entitas');
       	 $table->string('tipe_entitas'); // Perwakilan / Dalam Negeri
       	 $table->string('lokasi');
       	 $table->string('kontak')->nullable();
       	 $table->integer('jumlah_hs')->nullable();
       	 $table->integer('jumlah_ls')->nullable();
       	 $table->timestamps();
    	});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satkers');
    }
};
