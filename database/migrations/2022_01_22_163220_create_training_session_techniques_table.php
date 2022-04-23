<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSessionTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_session_techniques', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('training_session_id');
            $table->bigInteger('academy_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('youtube_id')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('training_session_techniques');
    }
}
