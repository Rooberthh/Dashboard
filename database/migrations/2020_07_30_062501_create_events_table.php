<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('calendar_id');
            $table->string('google_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('allday')->default(false);
            $table->datetime('started_at');
            $table->datetime('ended_at');
            $table->timestamps();

            $table->foreign('calendar_id')
                ->references('id')->on('calendars')
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
        Schema::dropIfExists('events');
    }
}
