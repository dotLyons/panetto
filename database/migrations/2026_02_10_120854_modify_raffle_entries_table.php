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
        // Rename column only if the old column exists (avoids errors on existing DBs)
        if (Schema::hasColumn('raffle_entries', 'ticket_number')) {
            Schema::table('raffle_entries', function (Blueprint $table) {
                $table->renameColumn('ticket_number', 'table_number');
            });
        }

        // Add visit_time if it doesn't already exist
        if (!Schema::hasColumn('raffle_entries', 'visit_time')) {
            Schema::table('raffle_entries', function (Blueprint $table) {
                // add visit_time after the (new) `table_number` column
                $table->string('visit_time', 5)->nullable()->after('table_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop visit_time if it exists
        if (Schema::hasColumn('raffle_entries', 'visit_time')) {
            Schema::table('raffle_entries', function (Blueprint $table) {
                $table->dropColumn('visit_time');
            });
        }

        // Rename back if `table_number` exists
        if (Schema::hasColumn('raffle_entries', 'table_number')) {
            Schema::table('raffle_entries', function (Blueprint $table) {
                $table->renameColumn('table_number', 'ticket_number');
            });
        }
    }
};
