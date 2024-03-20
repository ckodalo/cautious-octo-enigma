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
        Schema::create('public_key_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('credential_id'); 
            $table->string('raw_id');
            $table->text('client_data_json');
            $table->text('attestation_object');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_key_credentials');
    }
};
