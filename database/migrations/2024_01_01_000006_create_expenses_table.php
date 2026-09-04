<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->decimal('amount', 12, 2);
            $table->enum('distribution_type', ['flat', 'custom_percent', 'purchase_percent'])
                  ->comment('flat=সমান ভাগ, custom_percent=কাস্টম %, purchase_percent=ক্রয়মূল্য অনুযায়ী %');
            $table->text('description')->nullable();
            $table->date('expense_date');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['template_id', 'distribution_type']);
        });

        Schema::create('expense_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained()->cascadeOnDelete();
            $table->foreignId('animal_id')->constrained()->cascadeOnDelete();
            $table->decimal('percentage', 5, 2)->default(0);
            $table->decimal('amount', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['expense_id', 'animal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_distributions');
        Schema::dropIfExists('expenses');
    }
};
