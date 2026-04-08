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
        Schema::table('loans', function (Blueprint $table) {
        $table->enum('book_condition', ['baik', 'rusak', 'hilang'])->nullable();
        $table->integer('damage_fee')->nullable();
        $table->enum('payment_method', ['tunai', 'transfer'])->nullable();
        $table->string('guarantee')->nullable(); // contoh: KTM / KTP
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            //
        });
    }
};
