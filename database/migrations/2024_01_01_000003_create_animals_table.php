<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['cow', 'buffalo', 'camel', 'goat', 'sheep', 'other']);
            $table->string('name')->nullable();
            $table->unsignedTinyInteger('total_shares')->default(1);
            $table->decimal('purchase_price', 12, 2)->default(0);
            $table->enum('status', ['pending', 'purchased', 'slaughtered'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['template_id', 'type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
