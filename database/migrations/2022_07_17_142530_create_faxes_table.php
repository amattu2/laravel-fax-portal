<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('faxes', function (Blueprint $table) {
      $table->id();
      $table->string('from')->index();
      $table->string('to');
      $table->string('sid')->index()->unique();
      $table->string('media_url');
      $table->binary('content')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('faxes');
  }
};
