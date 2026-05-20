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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();

        $table->foreignId('satker_id')->constrained()->onDelete('cascade');

        $table->string('kontak')->nullable();
        $table->string('kepala')->nullable();
        $table->string('ppk')->nullable();
        $table->string('bendahara')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
