<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('articles', function (Blueprint $table) {
        $table->unsignedBigInteger('daily_views')->default(0);
        $table->unsignedBigInteger('weekly_views')->default(0);
        $table->unsignedBigInteger('monthly_views')->default(0);
        $table->unsignedBigInteger('yearly_views')->default(0);
        $table->unsignedBigInteger('views')->default(0);
    });
}

public function down()
{
    Schema::table('articles', function (Blueprint $table) {
        $table->dropColumn(['daily_views', 'weekly_views', 'monthly_views', 'yearly_views', 'views']);
    });
}
};
