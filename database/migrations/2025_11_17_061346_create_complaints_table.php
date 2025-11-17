<?php

// database/migrations/xxxx_xx_xx_create_complaints_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('title');
            $table->text('description');
            $table->string('evidence_file')->nullable(); // bukti keluhan (foto/file)

            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])
                  ->default('pending');

            $table->unsignedTinyInteger('rating')->nullable(); // 1–5
            $table->text('feedback')->nullable();                // komentar mahasiswa

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
