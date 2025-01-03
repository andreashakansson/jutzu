<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipatedTrainingSessionRequest;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Models\TrainingSessionParticipant;
use App\Services\TechniqueService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TrainingSessionController extends Controller
{
    public function create(): Response
    {
        Auth::user()->academies()->firstOrFail();

        $data = [
            'trainingSession' => [
                'id' => null,
                'date' => Carbon::now()->format('Y-m-d'),
                'type' => 'regular',
                'notes' => '',
                'techniques' => []
            ],
            'types' => $this->getTypesTranslated(),
            'allTechniques' => $this->getAcademyTechniques()
        ];
        return Inertia::render('TrainingSession/CreateEdit', $data);
    }

    public function edit($trainingSessionId): Response
    {
        $trainingSession = Auth::user()->academies()->first()->trainingSessions()->findOrFail($trainingSessionId);

        $techniques = [];
        foreach ($trainingSession->techniques as $technique) {
            $techniques[] = [
                'id' => $technique->id,
                'name' => $technique->name,
                'description' => $technique->description,
                'youtube_url' => $technique->youtube_url
            ];
        }
        $data = [
            'trainingSession' => [
                'id' => $trainingSession->id,
                'date' => $trainingSession->date->format('Y-m-d'),
                'type' => $trainingSession->type,
                'notes' => $trainingSession->notes,
                'techniques' => $techniques
            ],
            'types' => $this->getTypesTranslated(),
            'allTechniques' => $this->getAcademyTechniques()
        ];
        return Inertia::render('TrainingSession/CreateEdit', $data);
    }

    public function submit(StoreTrainingSessionRequest $request)
    {
        $user = Auth::user();
        $academy = $user->academies()->firstOrFail();

        $id = $request->input('id');
        if ($id) {
            $trainingSession = $academy->trainingSessions()->findOrFail($id);
            $trainingSession->fill([
                'date' => $request->input('date'),
                'type' => $request->input('type'),
                'notes' => $request->input('notes'),
            ]);
            $trainingSession->save();
            $trainingSession->techniques()->detach();
            $message = __('Training session has been updated!');
        } else {
            $trainingSession = $academy->trainingSessions()->create([
                'date' => $request->input('date'),
                'type' => $request->input('type'),
                'notes' => $request->input('notes'),
                'created_by' => $user->id
            ]);
            $message = __('Training session has been added!');
        }

        if ($request->has('techniques')) {
            foreach ($request->input('techniques') as $technique) {
                $youtubeUrl = null;
                $youtubeId = null;
                if ($technique['youtube_url']) {
                    $service = new TechniqueService();
                    $youtubeUrl = $service->getVideoUrl($technique['youtube_url']);
                    $youtubeId = $service->getYoutubeId($youtubeUrl);
                }

                if (is_integer($technique['id'])) {
                    // Attach existing technique
                    $trainingSession->techniques()->attach($technique['id']);
                } else {
                    // Create technique
                    $trainingSession->techniques()->create([
                        'academy_id' => $academy->id,
                        'name' => $technique['name'],
                        'description' => $technique['description'],
                        'youtube_url' => $youtubeUrl,
                        'youtube_id' => $youtubeId,
                        'created_by' => $user->id
                    ]);
                }
            }
        }

        return Redirect::route('dashboard')->with(['toast' => ['message' => $message]]);
    }

    public function delete($trainingSessionId)
    {
        $trainingSession = Auth::user()->academies()->first()->trainingSessions()->findOrFail($trainingSessionId);

        // Detach techniques
        $trainingSession->techniques()->detach();

        // Delete participants
        $trainingSession->participants()->delete();

        // Delete training session
        $trainingSession->delete();

        $message = __('Training session has been deleted!');

        return Redirect::route('dashboard')->with(['toast' => ['message' => $message]]);
    }

    public function participant(
        $trainingSessionId,
        ParticipatedTrainingSessionRequest $request
    ): RedirectResponse {
        $trainingSession = Auth::user()->academies()->first()->trainingSessions()->findOrFail($trainingSessionId);

        TrainingSessionParticipant::updateOrCreate(
            ['training_session_id' => $trainingSession->id, 'user_id' => Auth::user()->id],
            ['is_participant' => $request->input('is_participant')]
        );
        return Redirect::route('dashboard');
    }

    private function getAcademyTechniques()
    {
        $allTechniques = [];
        foreach (Auth::user()->academies()->first()->techniques as $technique) {
            $allTechniques[] = [
                'id' => $technique->id,
                'name' => $technique->name
            ];
        }
        return $allTechniques;
    }

    private function getTypesTranslated(): array
    {
        $types = config('project.trainingSession.types');
        $out = [];
        foreach ($types as $typeKey => $typeName) {
            $out[$typeKey] = __($typeName);
        }
        return $out;
    }
}
