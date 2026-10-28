<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->unique();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('outlet_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->dateTime('arrived_at');
            $table->unsignedSmallInteger('unit');
            $table->decimal('total', 10, 2);
            $table->string('status', 20)->default('received');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
