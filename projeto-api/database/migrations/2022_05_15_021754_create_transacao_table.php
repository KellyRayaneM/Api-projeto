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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id('id_transaction')->primary();;
            $table->id('id_user_out');
            $table->id('id_user_in');
            $table->double('value');
            $table->softDeletes();
            $table->foreign('id_user_out')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_user_in')->references('id_user')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transaction');
    }
};
