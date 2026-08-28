<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customization_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number', 30)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sidecar_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('estimated_price', 12, 2)->default(0);
            $table->decimal('final_price', 12, 2)->nullable();
            $table->enum('status', [
                'pending',
                'reviewing',
                'approved',
                'in_production',
                'ready_for_pickup',
                'completed',
                'cancelled',
                'rejected',
            ])->default('pending');
            $table->text('special_instructions')->nullable();
            $table->string('preferred_dimensions', 200)->nullable();
            $table->text('design_notes')->nullable();
            $table->string('design_image')->nullable();
            $table->text('status_notes')->nullable();
            $table->timestamp('date_submitted')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('in_production_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customization_requests');
    }
};
