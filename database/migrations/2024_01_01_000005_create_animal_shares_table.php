<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->foreignId('animal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('shares')->default(1);
            $table->decimal('share_amount', 12, 2)->default(0)->comment('Calculated share cost');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['animal_id', 'partner_id']);
            $table->index(['template_id', 'partner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_shares');
    }
};
