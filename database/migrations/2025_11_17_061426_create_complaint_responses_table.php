<?php
// database/migrations/xxxx_xx_xx_create_complaint_responses_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaint_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('admin_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->text('note');                 // catatan tindak lanjut
            $table->string('attachment')->nullable(); // bukti perbaikan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_responses');
    }
};
