<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    public function up()
    {
        Schema::create('scholarship_banners', function (Blueprint $table) {
            $table->id();
            $table->string('image_path'); // Store the image path
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scholarship_banners');
    }
}
