<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('role_id')->default(2)->constrained('roles'); // Agregar el campo de rol
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Insertar roles por defecto
        DB::table('roles')->insert([
            ['nombre' => 'admin'],
            ['nombre' => 'usuario'],
            ['nombre' => 'evaluador']
        ]);

        // Insertar usuarios de prueba
        DB::table('users')->insert([
            [
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'role_id' => 1, // rol admin
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'User Test',
                'email' => 'user@test.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role_id' => 2, // rol usuario
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
