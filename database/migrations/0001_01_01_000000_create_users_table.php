<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            //0 admin, 3 felh, 1 librarian, 2 warehouseman 
            // $table->boolean('permission')->default(1);
            $table->boolean('role')->default(3);
            $table->timestamps();
        });


        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        User::create([
            'name' => 'admin', 
            'email' => 'admin@admin.hu',
            'password' => Hash::make('admin12345'),
            'role' => 0
        ]);
        User::create([
            'name' => 'Vicc Elek', 
            'email' => 'vicce@gmail.com',
            'password' => Hash::make('user12345'),
        ]);

        User::create([
            'name' => 'librarian', 
            'email' => 'librarian@gmail.com',
            'password' => Hash::make('librarian12345'),
            'role' => 1,
        ]);

        User::create([
            'name' => 'warehouseman', 
            'email' => 'warehouseman@gmail.com',
            'password' => Hash::make('warehouseman12345'),
            'role' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
