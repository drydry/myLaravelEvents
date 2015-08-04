<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEventTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventTypes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner');
            $table->string('title');
            $table->string('description', 255);
            $table->integer('capacity');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('events', function($table){
            $table->integer('type')->after('host');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('eventTypes');
        Schema::table('events', function($table){
            $table->dropColumn('type');
        });
    }
}
