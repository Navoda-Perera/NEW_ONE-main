<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Rename mobile to telephone
            $table->renameColumn('mobile', 'telephone');

            // Update type enum to include prepaid
            DB::statement("ALTER TABLE companies MODIFY COLUMN type ENUM('cash', 'credit', 'franking', 'prepaid') DEFAULT 'cash'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Revert telephone back to mobile
            $table->renameColumn('telephone', 'mobile');

            // Revert type enum
            DB::statement("ALTER TABLE companies MODIFY COLUMN type ENUM('cash', 'credit', 'franking') DEFAULT 'cash'");
        });
    }
};
