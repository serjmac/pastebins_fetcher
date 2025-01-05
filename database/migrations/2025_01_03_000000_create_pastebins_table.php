<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePastebinsTable extends Migration
{
    public function up()
    {
        Schema::create('pastebins', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->text('content');
            $table->timestamps();

            // Add a composite unique index for url, content, and created_at
            $table->unique(['url', 'content', 'created_at']);
        });

        Schema::create('pastebin_errors', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->text('error');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pastebins');
    }
}