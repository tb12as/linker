<?php

use App\Models\Link;
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
            if (!Schema::hasColumn('links', 'alpha_id_number')) {
                $table->string('alpha_id_number')->after('unique_code')->index();
            }
        });

        // fill alpla_id_number for existsing links
        $links = Link::withTrashed()->get();
        foreach ($links as $l) {
            $num = alphaID($l->unique_code, true);
            $l->alpha_id_number = $num;
            $l->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            if (Schema::hasColumn('links', 'alpha_id_number')) {
                $table->dropColumn('alpha_id_number');
            }
        });
    }
};
