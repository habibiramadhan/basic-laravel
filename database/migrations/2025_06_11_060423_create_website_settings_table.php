<?php
// database/migrations/xxxx_xx_xx_create_website_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->enum('type', ['text', 'textarea', 'email', 'phone', 'url'])->default('text');
            $table->string('description')->nullable();
            $table->timestamps();
            
            $table->index('key');
        });
    }

    public function down()
    {
        Schema::dropIfExists('website_settings');
    }
};