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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('photo_link')->nullable();
            $table->unsignedBigInteger('creator_user_id')->index();
            $table->timestamps();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('creator_user_id')
            ->references('id')
            ->on('users')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
