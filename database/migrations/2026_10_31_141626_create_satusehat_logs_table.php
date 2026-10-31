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
        Schema::create('satusehat_logs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->integer('encounter')->default(0);
            $table->integer('diagnosa')->default(0);
            $table->string('status')->default('success'); // success, partial, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satusehat_logs');
    }
};
