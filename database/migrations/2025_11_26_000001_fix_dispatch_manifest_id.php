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
        // First, update any existing dispatches that have null or empty manifest_id
        $dispatches = DB::table('dispatches')
            ->whereNull('manifest_id')
            ->orWhere('manifest_id', '')
            ->get();

        foreach ($dispatches as $dispatch) {
            // Generate unique manifest ID based on creation date
            $date = date('Ymd', strtotime($dispatch->created_at));
            $manifestId = 'MAN' . $date . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Ensure uniqueness
            while (DB::table('dispatches')->where('manifest_id', $manifestId)->exists()) {
                $manifestId = 'MAN' . $date . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }

            DB::table('dispatches')
                ->where('id', $dispatch->id)
                ->update(['manifest_id' => $manifestId]);
        }

        // Modify the table to make manifest_id NOT NULL
        Schema::table('dispatches', function (Blueprint $table) {
            $table->string('manifest_id')->nullable(false)->change();
            $table->unique('manifest_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispatches', function (Blueprint $table) {
            $table->dropUnique(['manifest_id']);
            $table->string('manifest_id')->nullable()->change();
        });
    }
};
