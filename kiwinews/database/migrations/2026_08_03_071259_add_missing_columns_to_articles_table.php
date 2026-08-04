<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'images')) {
                $table->json('images')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('articles', 'daily_views')) {
                $table->unsignedBigInteger('daily_views')->default(0);
            }
            if (!Schema::hasColumn('articles', 'weekly_views')) {
                $table->unsignedBigInteger('weekly_views')->default(0);
            }
            if (!Schema::hasColumn('articles', 'monthly_views')) {
                $table->unsignedBigInteger('monthly_views')->default(0);
            }
            if (!Schema::hasColumn('articles', 'yearly_views')) {
                $table->unsignedBigInteger('yearly_views')->default(0);
            }
            if (!Schema::hasColumn('articles', 'is_top_story')) {
                $table->boolean('is_top_story')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'images', 
                'daily_views', 
                'weekly_views', 
                'monthly_views', 
                'yearly_views', 
                'is_top_story'
            ]);
        });
    }
};