<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshop_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('workshop_partners')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('workshop_locations')->cascadeOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained('workshop_contacts')->nullOnDelete();
            $table->foreignId('service_type_id')->constrained('workshop_service_types')->cascadeOnDelete();
            $table->string('subscription_code')->unique();
            $table->enum('status', ['active', 'pending', 'expired', 'paused'])->default('pending');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->decimal('monthly_fee', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_subscriptions');
    }
};
