<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->longText('message');
            $table->string('file')->nullable();
            $table->bigInteger('inbox_id')->unsigned()->nullable();
            $table->foreign('inbox_id')->references('id')->on('inboxes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('sender_id')->unsigned();
            $table->bigInteger('receiver_id')->unsigned();
            $table->enum('type', ['notification','mail'])->default('mail');
            $table->tinyInteger('is_read')->default(0); // 0 ->unread , 1 ->is read
            $table->enum('sender_type', ['admin','user','supplier'])->default('admin');
            $table->enum('receiver_type', ['admin','user','supplier'])->default('user');

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
        Schema::dropIfExists('inboxes');
    }
}
