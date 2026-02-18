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
        Schema::create('highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // utente
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // capitolo
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade'); // capitolo
            $table->text('text'); // testo evidenziato
            $table->text('position')->nullable(); // posizione/coordinate della selezione, se vuoi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlights');
    }
};
