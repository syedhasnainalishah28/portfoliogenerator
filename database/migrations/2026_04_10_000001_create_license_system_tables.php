<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('duration_months');
            $table->decimal('price_usd', 8, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_title');
            $table->string('account_number');
            $table->string('logo')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('plan_id')->constrained();
            $table->string('license_key')->unique();
            $table->boolean('is_used')->default(false);
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_manually_generated')->default(false);
            $table->foreignId('generated_by_admin')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained();
            $table->foreignId('license_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->decimal('amount_usd', 8, 2);
            $table->decimal('amount_pkr', 10, 2)->nullable();
            $table->decimal('exchange_rate', 10, 4)->nullable();
            $table->foreignId('payment_method_id')->constrained();
            $table->string('transaction_hash')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('plans');
    }
};
