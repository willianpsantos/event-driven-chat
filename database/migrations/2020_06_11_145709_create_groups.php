<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);

        Schema::create('groups', function (Blueprint $table) {
            $table->string('id', 250)->nullable(false)->unique()->primary();
            $table->string('name', 255)->nullable(true);
            $table->text('description')->nullable(true);
            $table->unsignedBigInteger('user_creator_id')->nullable(false);
            $table->timestamp('created_at')->default( DB::raw('CURRENT_TIMESTAMP') );

            $table
                ->foreign('user_creator_id')
                ->references('id')
                ->on('users');
        });

        Schema::create('group_participants', function (Blueprint $table) {
            $table->string('id', 250)->nullable(false)->unique()->primary();
            $table->string('group_id', 250)->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->timestamp('added_at')->default(DB::raw(' CURRENT_TIMESTAMP '));

            $table
                ->foreign('group_id')
                ->references('id')
                ->on('groups');

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
        Schema::dropIfExists('group_participants');
        Schema::dropIfExists('groups');
    }
}
