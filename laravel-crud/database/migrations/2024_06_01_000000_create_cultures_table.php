<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cultures', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
            $table->string('emoji', 10);
            $table->string('flag_path', 255);
            $table->text('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cultures');
    }
};