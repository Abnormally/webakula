<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestbookPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guestbook_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->string('name', 100);
            $table->text('content');
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->timestamps();
            $table->integer('status')->nullable()->default(0);
            $table->unsignedTinyInteger('reaction')->nullable()->default(0);
        });
    }

    /**
     * Drop the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guestbook_posts');
    }
}
