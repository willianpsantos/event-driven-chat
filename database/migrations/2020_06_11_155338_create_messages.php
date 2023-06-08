<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->string('id', 250)->nullable(false)->unique()->primary();
            $table->unsignedBigInteger('user_owner_id')->nullable(false);
            $table->enum('conversation_in_group', [ 'Y', 'N' ])->default('N');
            $table->string('group_id', 250)->nullable(true);
            $table->unsignedBigInteger('user_receiver_id')->nullable(true);
            $table->timestamp('created_at', 6)->default( DB::raw(' CURRENT_TIMESTAMP(6) '));

            $table
                ->foreign('user_owner_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('user_receiver_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('group_id')
                ->references('id')
                ->on('groups');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->string('id', 250)->nullable(false)->unique()->primary();
            $table->string('conversation_id', 250)->nullable(false);

            $table->unsignedBigInteger('user_sender_id')->nullable(false);
            $table->unsignedBigInteger('user_receiver_id')->nullable(true);

            $table->enum('sent_via_group', ['Y', 'N'])->default('N')->nullable(true);
            $table->string('group_id',250)->nullable(true);

            $table->text('message')->nullable(true);
            $table->string('file_attached_path', 255)->nullable(true);
            $table->enum('file_attached_type', [ 'I', 'V', 'F' ])->default('I');

            $table->timestamp('message_sent_at', 6)->default(DB::raw(' CURRENT_TIMESTAMP(6) '))->nullable(true);
            $table->enum('message_read', ['Y', 'N'])->default('N')->nullable(true);
            $table->timestamp('message_read_at', 6)->nullable(true);

            $table
                ->foreign('conversation_id')
                ->references('id')
                ->on('conversations');

            $table
                ->foreign('user_sender_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('user_receiver_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('group_id')
                ->references('id')
                ->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
}
