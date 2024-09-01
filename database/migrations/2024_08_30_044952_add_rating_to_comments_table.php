<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('comments', 'rating')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->integer('rating')->default(0)->after('comment_text');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('comments', 'rating')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }
    }
};
