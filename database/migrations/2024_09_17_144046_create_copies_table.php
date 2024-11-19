<?php

use App\Models\copy;
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
        Schema::create('copies', function (Blueprint $table) {
            $table->id('copy_id');
            $table->foreignId('book_id')->references('book_id')->on('books');
            //0 puha; 1 kemány
            $table->boolean('hardcovered')->default(1);
            $table->year('publication')->default('2020');
            //0=könyvtár; 1=kikölcsönözve; 2=sselejt
            $table->smallInteger('status')->default(0);
            $table->timestamps();
        });

        copy::create([
            'book_id' => 1,
            'publication'=>'2000',
        ]);
        copy::create([
            'book_id' => 2, 
            'publication'=>'2021',
        ]);
        copy::create([
            'book_id' => 3, 
            'publication'=>'2010',
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies');
    }
};
