<?php

use App\Models\book;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('title');
            $table->integer('pieces');
            $table->timestamps();
        });

        book::create([
            'author' => 'Név1', 
            'title' => 'Cím1', 
            'pieces' => 2, 
        ]);
        book::create([
            'author' => 'Név2', 
            'title' => 'Cím2', 
            'pieces' => 4, 
        ]);
        book::create([
            'author' => 'Név3', 
            'title' => 'Cím3', 
            'pieces' => 1, 
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
