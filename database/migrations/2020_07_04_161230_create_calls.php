<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function(Blueprint $table) {
            $table->string('id', 250)->nullable(false)->unique()->primary();
            $table->unsignedBigInteger('user_host_id')->nullable(false);
            $table->string('peer_id', 255)->nullable(true);
            $table->timestamp('call_started_at', 6)->default(DB::raw(' CURRENT_TIMESTAMP(6) '));
            $table->timestamp('call_ends_at', 6)->nullable(true);
            $table->timestamp('created_at', 6)->default(DB::raw(' CURRENT_TIMESTAMP(6) ') );
        });

        Schema::create('call_invites', function (Blueprint $table) {
            $table->string('id', 250)->nullable(false)->unique()->primary();
            $table->string('call_id', 250)->nullable(false);
            $table->dateTime('valid_start_at')->nullable(false);
            $table->dateTime('valid_ends_at')->nullable(true);
            $table->string('invite_url', 255)->nullable(true);
            $table->timestamp('created_at', 6)->default(DB::raw(' CURRENT_TIMESTAMP(6) ') );

            $table
                ->foreign('call_id')
                ->references('id')
                ->on('calls');
        });

        Schema::create('call_members', function (Blueprint $table) {
            $table->string('id', 250)->nullable(false)->unique()->primary();
            $table->string('call_id', 250)->nullable(false);
            $table->string('call_invite_id', 250)->nullable(true);
            $table->string('peer_id', 255)->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->enum('accepted', [ 'Y', 'N' ])->default('N');
            $table->timestamp('created_at', 6)->default(DB::raw(' CURRENT_TIMESTAMP(6) ') );

            $table
                ->foreign('call_id')
                ->references('id')
                ->on('calls');

            $table
                ->foreign('call_invite_id')
                ->references('id')
                ->on('call_invites');

            $table
                ->foreign('user_id')
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
        Schema::dropIfExists('call_members');
        Schema::dropIfExists('call_invites');
        Schema::dropIfExists('calls');
    }
}
