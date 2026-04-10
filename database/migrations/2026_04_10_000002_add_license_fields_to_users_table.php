<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('license_id')->nullable()->constrained('licenses')->nullOnDelete()->after('remember_token');
            $table->timestamp('license_expires_at')->nullable()->after('license_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['license_id']);
            $table->dropColumn(['license_id', 'license_expires_at']);
        });
    }
};
