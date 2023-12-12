<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('composition_files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('disk');
            $table->foreignId('composition_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('composition_files');
    }
};
