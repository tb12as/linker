<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
