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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('SET NULL');
            $table->string('ip_address')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('shipping_address_id')->nullable()->references('id')->on('user_addresses')->onDelete('SET NULL');
            $table->foreignId('shipping_id')->nullable()->references('id')->on('shippings')->onDelete('SET NULL');
            $table->enum('payment_method',['cod','online'])->default('cod');
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->enum('status',['new','processing','out for delivery','delivered','canceled'])->default('new');
            $table->foreignId('coupon_id')->nullable()->references('id')->on('coupons')->onDelete('SET NULL');
            $table->float('sub_total');
            $table->float('discount')->nullable();;
            $table->float('total_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
