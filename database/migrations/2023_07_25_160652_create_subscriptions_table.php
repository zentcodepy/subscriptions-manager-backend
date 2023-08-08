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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services');
            $table->date('date_from');
            $table->date('date_to');
            $table->integer('duration_in_months');
            $table->integer('grace_period_in_days');
            $table->bigInteger('total_amount');
            $table->string('status', 20)->index();
            $table->string('payment_service_type', 20);
            $table->boolean('automatic_notification_enabled');
            $table->text('subscription_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
