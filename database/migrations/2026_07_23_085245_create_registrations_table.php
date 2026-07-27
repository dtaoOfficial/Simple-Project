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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
                    $table->string('child_name');
        $table->unsignedInteger('child_age');
        $table->string('parent_name');
        $table->string('parent_email');
        $table->string('parent_phone');
        $table->foreignId('programme_id')->constrained()->cascadeOnDelete();
        $table->string('payment_status')->default('pending');
        $table->decimal('payment_amount', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
