<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSynchronizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synchronizations', function (Blueprint $table) {
            $table->string('id');
            $table->morphs('synchronizable');
            $table->string('token')->nullable();
            $table->datetime('last_synchronized_at');
            $table->string('resource_id')->nullable();
            $table->datetime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('synchronizations');
    }
}
