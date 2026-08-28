<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customization_request_accessories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customization_request_id')->constrained('customization_requests', 'id', 'req_acc_req_id_fk')->cascadeOnDelete();
            $table->foreignId('accessory_id')->constrained('accessories', 'id', 'req_acc_acc_id_fk')->cascadeOnDelete();
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->unique(['customization_request_id', 'accessory_id'], 'req_acc_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customization_request_accessories');
    }
};
