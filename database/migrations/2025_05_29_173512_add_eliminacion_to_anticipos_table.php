<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEliminacionToAnticiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anticipos', function (Blueprint $table) {
            $table->softDeletes();
            $table->bigInteger('motivo_eliminacion_id')->nullable()->unsigned();
            $table->foreign('motivo_eliminacion_id')->references('id')->on('motivos')->onDelete('set null');
            $table->string('adjunto_eliminacion')->nullable();
            $table->bigInteger('user_eliminacion_id')->nullable()->unsigned();
            $table->foreign('user_eliminacion_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anticipos', function (Blueprint $table) {
            $table->dropForeign(['motivo_eliminacion_id']);
            $table->dropColumn('motivo_eliminacion_id');
            $table->dropColumn('adjunto_eliminacion');
            $table->dropForeign(['user_eliminacion_id']);
            $table->dropColumn('user_eliminacion_id');
            $table->dropSoftDeletes();
        });
    }
}
