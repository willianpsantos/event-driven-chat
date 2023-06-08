<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvents extends Migration
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
            $table->string('name', 255)->nullable(false);
            $table->string('subtitle', 255)->nullable(true);
            $table->text('description');
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->string('image', 255);
            $table->enum('show_in_home', [ 'Y', 'N' ]);
            $table->date('start_show_at');
            $table->date('ends_show_at');
            $table->enum('featured', [ 'Y', 'N' ]);
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

