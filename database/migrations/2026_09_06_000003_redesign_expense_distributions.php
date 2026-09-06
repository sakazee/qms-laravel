<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expense_distributions', function (Blueprint $table) {
            $table->string('method', 10)->default('percent')->after('animal_id')
                  ->comment('percent=শতাংশ, amount=নির্দিষ্ট পরিমাণ');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->index('template_id', 'expenses_template_id_index');
            $table->dropIndex(['template_id', 'distribution_type']);
            $table->dropColumn('distribution_type');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->enum('distribution_type', ['flat', 'custom_percent', 'purchase_percent'])
                  ->default('flat')
                  ->comment('flat=সমান ভাগ, custom_percent=কাস্টম %, purchase_percent=ক্রয়মূল্য অনুযায়ী %');
            $table->index(['template_id', 'distribution_type']);
            $table->dropIndex(['template_id'], 'expenses_template_id_index');
        });

        Schema::table('expense_distributions', function (Blueprint $table) {
            $table->dropColumn('method');
        });
    }
};