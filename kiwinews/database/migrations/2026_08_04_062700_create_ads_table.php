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
    Schema::create('ads', function (Blueprint $table) {
        $table->id();
        // Bagong Contact Details
        $table->string('company_name')->nullable();
        $table->string('contact_number')->nullable();
        $table->string('email')->nullable();
        
        $table->string('title');
        $table->text('description')->nullable();
        $table->text('image_url');
        $table->string('promo_code')->nullable();
        $table->string('badge_text')->default('Limited Offer');
        $table->string('button_text')->default('Alamin Pa');
        $table->string('button_link')->default('#');
        $table->boolean('is_active')->default(true);
        
        // Status para sa approval workflow ('pending', 'approved', 'rejected')
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
        
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};