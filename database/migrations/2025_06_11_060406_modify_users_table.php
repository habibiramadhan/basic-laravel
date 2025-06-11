<?php
// database/migrations/xxxx_xx_xx_modify_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lengkap')->after('name');
            $table->string('no_telepon', 20)->nullable()->after('email');
            $table->text('alamat')->nullable()->after('no_telepon');
            $table->enum('role', ['admin', 'customer'])->default('customer')->after('alamat');
            $table->timestamp('email_verified_at')->nullable()->change();
            
            $table->index('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'no_telepon', 'alamat', 'role']);
        });
    }
};