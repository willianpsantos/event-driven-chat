<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_owner_id');
            $table->unsignedBigInteger('user_contact_id');

            $table->enum('can_phone', ['Y', 'N'])->default('Y');
            $table->enum('can_video', ['Y', 'N'])->default('Y');
            $table->enum('can_message', ['Y', 'N'])->default('Y');

            $table->timestamp('last_call_at')->nullable(true);
            $table->timestamp('last_message_at')->nullable(true);
            $table->timestamp('created_at')->default( DB::raw(' CURRENT_TIMESTAMP ') );

            $table->unique([ 'user_owner_id', 'user_contact_id']);

            $table->foreign('user_owner_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('user_contact_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
