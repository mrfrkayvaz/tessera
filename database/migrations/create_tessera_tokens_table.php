<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $table_name = config('tessera.table_name', 'tokens');

        Schema::create($table_name, function (Blueprint $table) {
            $table->id();

            $table->string('identifier', 20)->index();
            $table->string('code', 20)->index();
            $table->string('secret')->nullable();
            $table->string('action', 100)->index();
            $table->unsignedInteger('attempts')->default(0)->index();
            $table->unsignedInteger('max_attempts')->default(5)->index();
            $table->timestamp('expires_at')->index();
            $table->json('params')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        $table_name = config('tessera.table_name', 'tokens');
        Schema::dropIfExists($table_name);
    }
};