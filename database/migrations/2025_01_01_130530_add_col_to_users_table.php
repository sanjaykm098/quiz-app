<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('password')->index();
            $table->boolean('is_email_verified')->default(false)->after('is_active')->index();
            $table->string('email_verification_token', 6)->nullable();
            $table->boolean('is_banned')->default(false)->after('is_email_verified')->index();
            $table->timestamp('banned_at')->nullable()->after('is_banned');
            $table->text('ban_reason')->nullable()->after('banned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('is_email_verified');
            $table->dropColumn('email_verification_token');
            $table->dropColumn('is_banned');
        });
    }
};
