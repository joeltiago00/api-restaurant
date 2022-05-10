<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->after('password');
            $table->unsignedBigInteger('job_function_id')->after('role_id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
            $table->foreign('job_function_id')
                ->references('id')
                ->on('job_functions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['job_function_id']);
            $table->dropColumn('role_id');
            $table->dropColumn('job_function_id');
        });
    }
};
