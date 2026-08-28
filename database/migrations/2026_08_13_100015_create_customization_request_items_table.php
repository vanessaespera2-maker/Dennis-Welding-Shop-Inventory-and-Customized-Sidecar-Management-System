<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customization_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customization_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->timestamps();

            $table->index(['customization_request_id', 'inventory_item_id'], 'req_item_req_inv_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customization_request_items');
    }
};
