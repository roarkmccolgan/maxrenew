<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterForeignKeyOnQASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('q_a_s', function ($table) {
            $table->dropForeign('q_a_parent_id_foreign');

            $table->foreign('parent_id')
                ->references('id')->on('q_a_s')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('q_a_s', function ($table) {
            $table->dropForeign('q_a_s_parent_id_foreign');

            $table->foreign('parent_id')
                ->references('id')->on('q_a')
                ->onDelete('cascade');
        });
    }
}
