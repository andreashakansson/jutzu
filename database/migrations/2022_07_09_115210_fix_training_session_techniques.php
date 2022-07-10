<?php

use App\Models\Technique;
use App\Models\TrainingSession;
use Illuminate\Database\Migrations\Migration;

class FixTrainingSessionTechniques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $techniques = Technique::all();
        foreach ($techniques as $technique) {
            if ($technique->training_session_id !== 0) {
                $session = TrainingSession::find($technique->training_session_id);
                $session->techniques()->attach($technique->id);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
