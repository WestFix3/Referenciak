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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin')->default(false); // admin mező
            $table->string('phone_number'); // telefonszám
            $table->string('card_number', 16)->unique(); // kártyaszám, 16 karakter, egyedi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['admin', 'phone_number', 'card_number']); // az oszlopok törlése visszagörgetéskor
        });
    }
};
